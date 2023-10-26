<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

/**
 *	Parses PHP Files containing a Class or Methods using regular expressions (slow).
 *
 *	Copyright (c) 2008-2023 Christian Würker (ceusmedia.de)
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Parser_Parser
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2008-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/Common
 *	@todo			support multiple return types separated with |
 */
namespace CeusMedia\PhpParser\Parser;

use CeusMedia\Common\Alg\Text\Unicoder;
use CeusMedia\Common\FS\File\Reader as FileReader;
use CeusMedia\PhpParser\Parser\Doc\Regular as DocParser;
use CeusMedia\PhpParser\Parser\Doc\Decorator as DocDecorator;
use CeusMedia\PhpParser\Structure\File_;
use CeusMedia\PhpParser\Structure\Class_;
use CeusMedia\PhpParser\Structure\Interface_;
use CeusMedia\PhpParser\Structure\Trait_;
use CeusMedia\PhpParser\Structure\Variable_;
use CeusMedia\PhpParser\Structure\Member_;
use CeusMedia\PhpParser\Structure\Function_;
use CeusMedia\PhpParser\Structure\Method_;
use CeusMedia\PhpParser\Structure\Parameter_;
use CeusMedia\PhpParser\Structure\Author_;
use CeusMedia\PhpParser\Structure\License_;
use CeusMedia\PhpParser\Structure\Return_;
use CeusMedia\PhpParser\Structure\Throws_;


/**
 *	Parses PHP Files containing a Class or Methods using regular expressions (slow).
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Parser_Parser
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2008-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/Common
 *	@todo			Code Doc
 */
class Regular
{
	protected string $regexClass	= '@^(abstract )?(final )?(interface |class |trait )([\w]+)( extends ([\w]+))?( implements ([\w]+)(, ([\w]+))*)?(\s*{)?@i';
	protected string $regexMethod	= '@^(abstract )?(final )?(static )?(protected |private |public )?(static )?function &?\s*([\w]+)\((.*)\)(\s*:\s*(\S+))?(\s*{\s*)?;?\s*$@s';
	protected string $regexParam	= '@^((\S+) )?((&\s*)?\$([\w]+))( ?= ?([\S]+))?$@s';
	protected string $regexVariable	= '@^(static\s+)?(protected|private|public|var)\s+(static\s+)?\$(\w+)(\s+=\s+([^(]+))?.*$@';
	protected array $varBlocks		= array();
	protected array $openBlocks		= array();
	protected int $lineNumber		= 0;

	protected DocParser $docParser;
	protected DocDecorator $docDecorator;

	public function __construct()
	{
		$this->docParser	= new DocParser;
		$this->docDecorator	= new DocDecorator();
	}

	const LEVEL_START			= 0;
	const LEVEL_CLASS_OPEN		= 1;

	/**
	 *	Parses a PHP File and returns nested Array of collected Information.
	 *	@access		public
	 *	@param		string		$fileName		File Name of PHP File to parse
	 *	@param		string		$innerPath		Base Path to File to be removed in Information
	 *	@return		File_
	 */
	public function parseFile( string $fileName, string $innerPath ): File_
	{
		$content		= FileReader::load( $fileName );
		if( !Unicoder::isUnicode( $content ) )
			$content	= Unicoder::convertToUnicode( $content );

		$lines			= explode( "\n", $content );
		$fileBlock		= NULL;
		$openClass		= FALSE;
		$function		= NULL;
		$functionBody	= array();
		$file			= new File_;
		$file->setBasename( basename( $fileName ) );
		$file->setPathname( substr( str_replace( "\\", "/", $fileName ), strlen( $innerPath ) ) );
		$file->setUri( str_replace( "\\", "/", $fileName ) );

		$level	= self::LEVEL_START;
		$class	= NULL;
		do{
			$originalLine	= array_shift( $lines );
			$line			= preg_replace( '@((#|//).*)$@', '', $originalLine );		//  remove trailing comment
			$line			= trim( $line );											//  trim line, since whitespace does not matter for parsing
#			remark( ( $openClass ? "I" : "O" )." :: ".$level." :: ".$this->lineNumber." :: ".$line );
			$this->lineNumber ++;
			if( preg_match( "@^(<\?(php)?)|((php)?\?>)$@", $line ) )
				continue;

			if( str_ends_with( $line, '}' ) )
				$level--;

			if( $line == "/**" && $level < 2 ){
				$list	= array();
				while( !preg_match( "@\*?\*/\s*$@", $line ) ){
					$list[]	= $line;
					$line	= trim( array_shift( $lines ) );
					$this->lineNumber ++;
				}
				array_unshift( $lines, $line );
				$this->lineNumber --;
				if( $list ){
					$this->openBlocks[]	= $this->docParser->parseBlock( join( PHP_EOL, $list ) );
					if( !$fileBlock && !$class ){
						$fileBlock	= array_shift( $this->openBlocks );
						array_unshift( $this->openBlocks, $fileBlock );
						$this->docDecorator->decorateCodeDataWithDocData( $file, $fileBlock );
					}
				}
				continue;
			}
			if( !$openClass ){
				if( preg_match( $this->regexClass, $line, $matches ) ){
					$parts	= array_slice( $matches, -1 );
					while( !trim( array_pop( $parts ) ) )
						array_pop( $matches );
					$class	= $this->parseClassOrInterfaceOrTrait( $file, $matches );
					$openClass	= TRUE;
				}
				else if( preg_match( $this->regexMethod, $line, $matches ) ){
					$openClass	= FALSE;
					$function	= $this->parseFunction( $file, $matches );
					$file->setFunction( $function );
				}
			}
			else{
				if( preg_match( $this->regexClass, $line, $matches ) ){
					if( $class instanceof Class_ )
						$file->addClass( $class );
					else if( $class instanceof Trait_ )
						$file->addTrait( $class );
					else if( $class instanceof Interface_ )
						$file->addInterface( $class );
					array_unshift( $lines, $line );
					$this->lineNumber --;
					$openClass	= FALSE;
					$level		= self::LEVEL_CLASS_OPEN;
					continue;
				}
				if( preg_match( $this->regexMethod, $line, $matches ) ){
					$method		= $this->parseMethod( $class, $matches );
					$function	= $matches[6];
					$class->setMethod( $method );
				}
				else if( $level <= self::LEVEL_CLASS_OPEN ){
					if( preg_match( $this->docParser->regexVariable, $line, $matches ) ){
						if( $class )
							$this->varBlocks[$class->getName()."::".$matches[2]]	= $this->docParser->parseMember( $matches );
						else
							$this->varBlocks[$matches[2]]	= $this->docParser->parseVariable( $matches );
					}
					else if( preg_match( $this->regexVariable, $line, $matches ) ){
//						print_m( $this->openBlocks );die;
						$name		= $matches[4];
						if( $class ){
							$key		= $class->getName()."::".$name;
							$varBlock	= $this->varBlocks[$key] ?? NULL;
							$variable	= $this->parseMember( $class, $matches, $varBlock );
							if( $class instanceof Class_ || $class instanceof Trait_ )
								$class->setMember( $variable );
						}
						else{
							print( 'Parser Error: found var after class -> not handled yet' );
/*							$key		= $name;
							$varBlock	= isset( $this->varBlocks[$key] ) ? $this->varBlocks[$key] : NULL;
							$variable	= $this->parseMember( $matches, $varBlock );*/
						}
					}
				}
				else if( $level > self::LEVEL_CLASS_OPEN && $function ){
					$functionBody[$function][]	= $originalLine;
				}
			}
			if( str_ends_with( $line, '{' ) )
				$level++;
			if( $level < self::LEVEL_CLASS_OPEN && !preg_match( $this->regexClass, $line, $matches ) )
				$openClass	= FALSE;
		}
		while( $lines );

		$file->setSourceCode( $content );
		if( $class ){
			foreach( $class->getMethods() as $methodName => $method )
				if( isset( $functionBody[$methodName] ) )
					$method->setSourceCode( $functionBody[$methodName] );
			if( $class instanceof Class_ )
				$file->addClass( $class );
			else if( $class instanceof Trait_ )
				$file->addTrait( $class );
			else if( $class instanceof Interface_ )
				$file->addInterface( $class );
		}
		return $file;
	}

	//  --  PROTECTED  --  //

	/**
	 *	Parses a Class Signature and returns collected Information.
	 *	@access		protected
	 *	@param		File_				$parent			File Object of current Class
	 *	@param		array				$matches		Matches of RegEx
	 *	@return		Interface_|Class_|Trait_
	 */
	protected function parseClassOrInterfaceOrTrait( File_ $parent, array $matches ): Class_|Interface_|Trait_
	{
		switch( strtolower( trim( $matches[3] ) ) ){
			case 'interface':
				$artefact	= new Interface_( $matches[4] );
				if( isset( $matches[5] ) )
					$artefact->setExtendedInterfaceName( $matches[6] );
				break;
			case 'trait':
				$artefact	= new Trait_( $matches[4] );
//				if( isset( $matches[5] ) )
//					$artefact->setExtendedInterfaceName( $matches[6] );
//				$artefact->setFinal( (bool) $matches[2] );
				break;
			default:
				$artefact	= new Class_( $matches[4] );
				if( isset( $matches[5] ) )
					$artefact->setExtendedClassName( $matches[6] );
				$artefact->setFinal( (bool) $matches[2] );
				$artefact->setAbstract( (bool) $matches[1] );
				if( isset( $matches[7] ) )
					foreach( array_slice( $matches, 8 ) as $match )
						if( trim( $match ) && !preg_match( "@^,|{@", trim( $match ) ) )
							$artefact->setImplementedInterfaceName( trim( $match ) );
				break;
		}
		$artefact->setParent( $parent );
		$artefact->setLine( $this->lineNumber );
//		$artefact->setType( $matches[3] );
		if( $this->openBlocks ){
			$this->docDecorator->decorateCodeDataWithDocData( $artefact, array_pop( $this->openBlocks ) );
			$this->openBlocks	= array();
		}
		if( !$artefact->getCategory() && $parent->getCategory() )
			$artefact->setCategory( $parent->getCategory() );
		if( !$artefact->getPackage() && $parent->getPackage() )
			$artefact->setPackage( $parent->getPackage() );
		return $artefact;
	}

	/**
	 *	Parses a Function Signature and returns collected Information.
	 *	@access		protected
	 *	@param		File_				$parent			Parent File Data Object
	 *	@param		array				$matches		Matches of RegEx
	 *	@return		Function_
	 */
	protected function parseFunction( File_ $parent, array $matches ): Function_
	{
		$function	= new Function_( $matches[6] );
		$function->setParent( $parent );
		$function->setLine( $this->lineNumber );
		if( isset( $matches[8] ) )
			$function->setReturn( new Return_( $matches[9] ) );

		if( trim( $matches[7] ) ){
			$paramList	= array();
			foreach( explode( ",", $matches[7] ) as $param ){
				$param	 = trim( $param );
				if( !preg_match( $this->regexParam, $param, $matches ) )
					continue;
				$function->setParameter( $this->parseParameter( $function, $matches ) );
			}
		}
		if( $this->openBlocks ){
			$methodBlock	= array_pop( $this->openBlocks );
			$this->docDecorator->decorateCodeDataWithDocData( $function, $methodBlock );
			$this->openBlocks	= array();
		}
		return $function;
	}

	/**
	 *	Parses a Class Member Signature and returns collected Information.
	 *	@access		protected
	 *	@param		Class_|Interface_|Trait_	$parent			Parent Class Data Object
	 *	@param		array						$matches		Matches of RegEx
	 *	@param		mixed|NULL					$docBlock		Variable data object from Doc Parser
	 *	@return		Member_
	 */
	protected function parseMember( Class_|Interface_|Trait_ $parent, array $matches, mixed $docBlock = NULL ): Member_
	{
		$variable			= new Member_( $matches[4], NULL, NULL );
		$variable->setParent( $parent );
		$variable->setLine( $this->lineNumber );
		if( isset( $matches[5] ) )
			$variable->setDefault( preg_replace( "@;$@", "", $matches[6] ) );
		if( !empty( $matches[2] ) )
			$variable->setAccess( $matches[2] == "var" ? NULL : $matches[2] );
		$variable->setStatic( (bool) trim( $matches[3] ) );

		if( NULL !== $docBlock )
			if( $docBlock instanceof Variable_ )
				if( $docBlock->getName() == $variable->getName() )
					$variable->merge( $docBlock );
		return $variable;
	}

	/**
	 *	Parses a Method Signature and returns collected Information.
	 *	@access		protected
	 *	@param		Interface_			$parent			Parent Class Data Object
	 *	@param		array				$matches		Matches of RegEx
	 *	@return		Method_
	 */
	protected function parseMethod( Interface_ $parent, array $matches ): Method_
	{
		$method	= new Method_( $matches[6] );
		$method->setParent( $parent );
		$method->setLine( $this->lineNumber );
		if( !empty( $matches[4] ) )
			$method->setAccess( trim( $matches[4] ) );
		$method->setAbstract( (bool) $matches[1] );
		$method->setFinal( (bool) $matches[2] );
		$method->setStatic( (bool) $matches[3] || (bool) $matches[5] );

		$return		= new Return_( $matches[9] ?? 'void' );
		$return->setParent( $method );
		$method->setReturn( $return );

		if( trim( $matches[7] ) ){
			$paramList	= array();
			foreach( explode( ",", $matches[7] ) as $param ){
				$param	 = trim( $param );
				if( !preg_match( $this->regexParam, $param, $matches ) )
					continue;
				$method->setParameter( $this->parseParameter( $method, $matches ) );
			}
		}
		if( $this->openBlocks ){
			$methodBlock	= array_pop( $this->openBlocks );
			$this->docDecorator->decorateCodeDataWithDocData( $method, $methodBlock );
			$this->openBlocks	= array();
		}
#		if( !$method->getAccess() )
#			$method->setAccess( 'public' );
		return $method;
	}

	/**
	 *	Parses a Function/Method Signature Parameters and returns collected Information.
	 *	@access		protected
	 *	@param		Function_			$parent			Parent Function or Method Data Object
	 *	@param		array				$matches		Matches of RegEx
	 *	@return		Parameter_
	 */
	protected function parseParameter( Function_ $parent, array $matches ): Parameter_
	{
		$parameter	= new Parameter_( $matches[5] );
		$parameter->setParent( $parent );
		$parameter->setLine( $this->lineNumber );
		if( trim( $matches[2] ) )
			$parameter->setCast( $matches[2] );
		$parameter->setReference( (bool) $matches[4] );

		if( isset( $matches[6] ) )
			$parameter->setDefault( $matches[7] );
		return $parameter;
	}
}
