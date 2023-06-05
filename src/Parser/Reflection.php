<?php
/**
 *	...
 *
 *	Copyright (c) 2010-2020 Christian Würker (ceusmedia.de)
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
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/Common
 */
namespace CeusMedia\PhpParser\Parser;

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
 *	...
 *
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Parser_Parser
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/Common
 */
class Reflection
{
	protected bool $verbose	= TRUE;

	/**
	 *	Parses a PHP File and returns nested Array of collected Information.
	 *	@access		public
	 *	@param		string		$fileName		File Name of PHP File to parse
	 *	@param		string		$innerPath		Base Path to File to be removed in Information
	 *	@return		File_
	 */
	public function parseFile( string $fileName, string $innerPath ): File_
	{
		$content		= \CeusMedia\Common\FS\File\Reader::load( $fileName );
		if( !\CeusMedia\Common\Alg\Text\Unicoder::isUnicode( $content ) )
			$content		= \CeusMedia\Common\Alg\Text\Unicoder::convertToUnicode( $content );

		//  list builtin Classes
		$listClasses	= get_declared_classes();
		//  list builtin Interfaces
		$listInterfaces	= get_declared_interfaces();
		//  list builtin Interfaces
		$listTraits	= get_declared_traits();
		require_once( $fileName );
		//  get only own Classes
		$listClasses	= array_diff( get_declared_classes(), $listClasses );
		//  get only own Interfaces
		$listInterfaces	= array_diff( get_declared_interfaces(), $listInterfaces );
		//  get only own Traits
		$listInterfaces	= array_diff( get_declared_traits(), $listTraits );

		$file			= new File_;
		$file->setBasename( basename( $fileName ) );
		$file->setPathname( substr( str_replace( "\\", "/", $fileName ), strlen( $innerPath ) ) );
		$file->setUri( str_replace( "\\", "/", $fileName ) );
		$file->setSourceCode( $content );

		//  --  READING CLASSES  --  //
		//  count own Classes
/*		$countClasses	= count( $listClasses );
		if( $countClasses )
		{
			if( $this->verbose )
				remark( 'Parsing Classes ('.$countClasses.'):'.PHP_EOL );
			$listClasses	= $this->readFromClassList( $listClasses );
			$this->application->updateStatus( 'Done.', $countClasses, $countClasses );
		}
		foreach( $listClasses as $class )
			if( $class instanceof Class_ )
				$file->addClass( $class );

		//  --  READING INTERFACES  --  //
		//  count own Interfaces
		$countInterfaces	= count( $listInterfaces );
		if( $countInterfaces )
		{
			if( $this->verbose )
				print( 'Parsing Interfaces ('.$countInterfaces.'):'.PHP_EOL );
			$listInterfaces	= $this->readFromClassList( $listInterfaces );
			$this->application->updateStatus( 'Done.', $countInterfaces, $countInterfaces );
		}
		foreach( $listInterfaces as $interface )
			if( $interface instanceof Interface_ )
				$file->addInterface( $interface );
*/
/*		$functionBody	= array();
		$lines			= explode( "\n", $content );
		$fileBlock		= NULL;
		$openClass		= FALSE;
		$function		= NULL;

		$level	= 0;
		$class	= NULL;
		if( $class )
		{
			foreach( $class->getMethods() as $methodName => $method )
				if( isset( $functionBody[$methodName] ) )
					$method->setSourceCode( $functionBody[$methodName] );
		}*/
		return $file;
	}

	public function readClass( \ReflectionClass $class )
	{

		if( $class->isInterface() )
		{
			$object	= new Interface_( $class->name );
			//  NOT WORKING !!!
			if( $class->getParentClass() )
				$object->setExtendedInterfaceName( $class->getParentClass()->name );
		}
		else
		{
			$object	= new Class_( $class->name );
			$object->setFinal( $class->isFinal() );
			if( $class->getParentClass() )
				$object->setExtendedClassName( $class->getParentClass()->name );
			foreach( $class->getInterfaceNames() as $interfaceName )
				$object->setImplementedInterfaceName( $interfaceName );
			$object->setAbstract( $class->isAbstract() );

			foreach( $class->getProperties() as $property )
				$object->setMember( $this->readProperty( $property ) );
		}
		$object->setDescription( $class->getDocComment() );
		$object->setLine( $class->getStartLine().'-'.$class->getEndLine() );

		foreach( $class->getMethods() as $method )
			$object->setMethod( $this->readMethod( $method ) );


		$parser		= new \CeusMedia\PhpParser\Parser\Doc\Regular;
		$docData	= $parser->parseBlock( $class->getDocComment() );
		$decorator	= new \CeusMedia\PhpParser\Parser\Doc\Decorator();
		$decorator->decorateCodeDataWithDocData( $object, $docData );
		return $object;
	}

	public function readMethod( \ReflectionMethod $method ): Method_
	{
		$object	= new Method_( $method->name );
		$object->setDescription( $method->getDocComment() );
		foreach( $method->getParameters() as $parameter )
		{
			$parameter	= $this->readParameter( $parameter );
			$object->setParameter( $parameter );
		}
		$object->setLine( $method->getStartLine().'-'.$method->getEndLine() );
		$parser		= new \CeusMedia\PhpParser\Parser\Doc\Regular;
		$docData	= $parser->parseBlock( $method->getDocComment() );
		$decorator	= new \CeusMedia\PhpParser\Parser\Doc\Decorator();
		$decorator->decorateCodeDataWithDocData( $object, $docData );
		return $object;
	}

	public function readParameter( \ReflectionParameter $parameter ): Parameter_
	{
		$object	= new Parameter_( $parameter->name );
		$object->setReference( $parameter->isPassedByReference() );
		if( $parameter->getClass() )
			$object->setCast( $parameter->getClass()->name );
		if( $parameter->isDefaultValueAvailable() )
			$object->setDefault( $parameter->getDefaultValue() );
		return $object;
	}

	public function readProperty( \ReflectionProperty $property ): Member_
	{
		return new Member_( $property->name );
	}
}
