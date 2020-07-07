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
 *	@package		CeusMedia_Common_FS_File_PHP_Parser_Doc
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/Common
 */
namespace CeusMedia\PhpParser\Parser\Doc;

use CeusMedia\PhpParser\Structure\Variable_;
use CeusMedia\PhpParser\Structure\Member_;
use CeusMedia\PhpParser\Structure\Parameter_;
use CeusMedia\PhpParser\Structure\Author_;
use CeusMedia\PhpParser\Structure\License_;
use CeusMedia\PhpParser\Structure\Return_;
use CeusMedia\PhpParser\Structure\Throws_;
use CeusMedia\PhpParser\Structure\Trigger_;

/**
 *	...
 *
 *	@category		Library
 *	@package		CeusMedia_Common_FS_File_PHP_Parser_Doc
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/Common
 */
class Regular
{
	protected $regexParam		= '@^\*\s+\@param\s+(([\S]+)\s+)?(\$?([\S]+))\s*(.+)?$@';
	protected $regexReturn		= '@\*\s+\@return\s+(\w+)\s*(.+)?$@i';
	protected $regexThrows		= '@\*\s+\@throws\s+(\w+)\s*(.+)?$@i';
	protected $regexTrigger		= '@\*\s+\@trigger\s+(\w+)\s*(.+)?$@i';
	protected $regexAuthor		= '@\*\s+\@author\s+(.+)\s*(<(.+)>)?$@iU';
	protected $regexLicense		= '@\*\s+\@license\s+(\S+)( .+)?$@i';
	//  not used
	public $regexVariable	= '@^/\*\*\s+\@var\s+(\w+)\s+\$(\w+)(\s(.+))?\*\/$@s';

	/**
	 *	Parses a Doc Block and returns Array of collected Information.
	 *	@access		public
	 *	@param		array		$lines			Lines of Doc Block
	 *	@return		array
	 */
	public function parseBlock( $docComment )
	{
		$lines		= explode( "\n", $docComment );
		$data		= array();
		$descLines	= array();
		foreach( $lines as $line ){
			if( preg_match( $this->regexParam, $line, $matches ) ){
				$data['param'][$matches[4]]	= $this->parseParameter( $matches );
			}
			else if( preg_match( $this->regexReturn, $line, $matches ) ){
				$data['return']	= $this->parseReturn( $matches );
			}
			else if( preg_match( $this->regexThrows, $line, $matches ) ){
				$data['throws'][]	= $this->parseThrows( $matches );
			}
			else if( preg_match( $this->regexTrigger, $line, $matches ) ){
				$data['trigger'][]	= $this->parseTrigger( $matches );
			}
			else if( preg_match( $this->regexAuthor, $line, $matches ) ){
				$author	= new Author_( trim( $matches[1] ) );
				if( isset( $matches[3] ) )
					$author->setEmail( trim( $matches[3] ) );
				$data['author'][]	= $author;
			}
			else if( preg_match( $this->regexLicense, $line, $matches ) ){
				$data['license'][]	= $this->parseLicense( $matches );
			}
			else if( preg_match( "/^\*\s+@(\w+)\s*(.*)$/", $line, $matches ) ){
				switch( $matches[1] ){
					case 'implements':
					case 'deprecated':
					case 'todo':
					case 'copyright':
					case 'see':
					case 'uses':
					case 'link':
						$data[$matches[1]][]	= $matches[2];
						break;
					case 'since':
					case 'version':
					case 'access':
					case 'category':
					case 'package':
					case 'subpackage':
						$data[$matches[1]]	= $matches[2];
						break;
					default:
						break;
				}
			}
			else if( !$data && preg_match( "/^\*\s*([^@].+)?$/", $line, $matches ) )
				$descLines[]	= isset( $matches[1] ) ? trim( $matches[1] ) : "";
		}
		$data['description']	= trim( implode( "\n", $descLines ) );

		if( !isset( $data['throws'] ) )
			$data['throws']	= array();
		return $data;
	}

	/**
	 *	Parses a File/Class License Doc Tag and returns collected Information.
	 *	@access		public
	 *	@param		array		$matches		Matches of RegEx
	 *	@return		License_
	 */
	public function parseLicense( array $matches ): License_
	{
		$name	= NULL;
		$url	= NULL;
		if( isset( $matches[2] ) ){
			$url	= trim( $matches[1] );
			$name	= trim( $matches[2] );
			if( preg_match( "@^https?://@", $matches[2] ) ){
				$url	= trim( $matches[2] );
				$name	= trim( $matches[1] );
			}
		}
		else{
			$name	= trim( $matches[1] );
			if( preg_match( "@^https?://@", $matches[1] ) )
				$url	= trim( $matches[1] );
		}
		$license	= new License_( $name, $url );
		return $license;
	}

	/**
	 *	Parses a Class Member Doc Tag and returns collected Information.
	 *	@access		public
	 *	@param		array		$matches		Matches of RegEx
	 *	@return		Member_
	 */
	public function parseMember( array $matches ): Member_
	{
		$member	= new Member_( $matches[2], $matches[1], trim( $matches[4] ) );
		return $member;
	}

	/**
	 *	Parses a Function/Method Parameter Doc Tag and returns collected Information.
	 *	@access		public
	 *	@param		array		$matches		Matches of RegEx
	 *	@return		Parameter_
	 */
	public function parseParameter( array $matches ): Parameter_
	{
		$parameter	= new Parameter_( $matches[4], $matches[2] );
		if( isset( $matches[5] ) )
			$parameter->setDescription( $matches[5] );
		return $parameter;
	}

	/**
	 *	Parses a Function/Method Return Doc Tag and returns collected Information.
	 *	@access		public
	 *	@param		array		$matches		Matches of RegEx
	 *	@return		Return_
	 */
	public function parseReturn( array $matches ): Return_
	{
		$return	= new Return_( trim( $matches[1] ) );
		if( isset( $matches[2] ) )
			$return->setDescription( trim( $matches[2] ) );
		return $return;
	}

	/**
	 *	Parses a Function/Method Throws Doc Tag and returns collected Information.
	 *	@access		public
	 *	@param		array		$matches		Matches of RegEx
	 *	@return		Throws_
	 */
	public function parseThrows( array $matches ): Throws_
	{
		$throws	= new Throws_( trim( $matches[1] ) );
		if( isset( $matches[2] ) )
			$throws->setReason( trim( $matches[2] ) );
		return $throws;
	}

	/**
	 *	Parses a Function/Method Trigger Doc Tag and returns collected Information.
	 *	@access		public
	 *	@param		array		$matches		Matches of RegEx
	 *	@return		Trigger_
	 */
	public function parseTrigger( array $matches ): Trigger_
	{
		$trigger	= new Trigger_( trim( $matches[1] ) );
		if( isset( $matches[2] ) )
			$trigger->setCondition( trim( $matches[2] ) );
		return $trigger;
	}

	/**
	 *	Parses a Class Varible Doc Tag and returns collected Information.
	 *	@access		public
	 *	@param		array		$matches		Matches of RegEx
	 *	@return		Variable_
	 */
	public function parseVariable( array $matches ): Variable_
	{
		$variable	= new Variable_( $matches[2], $matches[1], trim( $matches[4] ) );
		return $variable;
	}
}
