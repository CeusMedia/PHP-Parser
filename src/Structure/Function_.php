<?php
/**
 *	File Function Data Class.
 *
 *	Copyright (c) 2008-2020 Christian Würker (ceusmedia.de)
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
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Structure\Traits\HasAuthors;
use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasName;
use CeusMedia\PhpParser\Structure\Traits\HasLinks;
use CeusMedia\PhpParser\Structure\Traits\HasLicense;
use CeusMedia\PhpParser\Structure\Traits\HasLineInFile;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;

/**
 *	File Function Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Function_
{
	use HasAuthors, HasDescription, HasName, HasLinks, HasLicense, HasLineInFile, HasVersion;

	protected $parent		= NULL;

	protected $since		= NULL;
	protected $version		= NULL;

	protected $todos		= array();
	protected $deprecations	= array();
	protected $throws		= array();
	protected $triggers		= array();

	protected $param		= array();
	protected $return		= NULL;

	protected $sourceCode	= NULL;

	public function __construct( string $name )
	{
		$this->setName( $name );
	}

	/**
	 *	Returns list of deprecation strings.
	 *	@access		public
	 *	@return		array			List of deprecation strings
	 */
	public function getDeprecations(): array
	{
		return $this->deprecations;
	}

	/**
	 *	Returns list of parameter data objects.
	 *	@access		public
	 *	@return		array			List of parameter data objects
	 */
	public function getParameters(): array
	{
		return $this->param;
	}

	/**
	 *	Returns parent File Data Object.
	 *	@access		public
	 *	@return		File_			Parent File Data Object
	 *	@throws		Exception		if not parent is set
	 */
	public function getParent()
	{
		if( !is_object( $this->parent ) )
			throw new Exception( 'Parser Error: Function has no related file' );
		return $this->parent;
	}

	/**
	 *	Returns return type as string or data object.
	 *	@access		public
	 *	@return		mixed			Return type as string or data object
	 */
	public function getReturn()
	{
		return $this->return;
	}

	/**
	 *	Returns method source code.
	 *	@access		public
	 *	@return		string			Method source code (multiline string)
	 */
	public function getSourceCode()
	{
		return $this->sourceCode;
	}

	/**
	 *	Returns list of thrown exceptions.
	 *	@access		public
	 *	@return		array			List of thrown exceptions
	 */
	public function getThrows(): array
	{
		return $this->throws;
	}

	/**
	 *	Returns list of todo strings.
	 *	@access		public
	 *	@return		array			List of todo strings
	 */
	public function getTodos(): array
	{
		return $this->todos;
	}

	/**
	 *	Returns list of triggers.
	 *	@access		public
	 *	@return		array			List of triggers
	 */
	public function getTriggers(): array
	{
		return $this->triggers;
	}

	public function merge( Function_ $function ): self
	{
		if( $this->name != $function->getName() )
			throw new \Exception( 'Not mergable' );
		if( $function->getDescription() )
			$this->setDescription( $function->getDescription() );
		if( $function->getSince() )
			$this->setSince( $function->getSince() );
		if( $function->getVersion() )
			$this->setVersion( $function->getVersion() );
		if( $function->getCopyright() )
			$this->setCopyright( $function->getCopyright() );
		if( $function->getReturn() )
			$this->setReturn( $function->getReturn() );

		foreach( $function->getAuthors() as $author )
			$this->setAuthor( $author );
		foreach( $function->getLinks() as $link )
			$this->setLink( $link );
		foreach( $function->getSees() as $see )
			$this->setSee( $see );
		foreach( $function->getTodos() as $todo )
			$this->setTodo( $todo );
		foreach( $function->getDeprecations() as $deprecation )
			$this->setDeprecation( $deprecation );
		foreach( $function->getThrows() as $throws )
			$this->setThrows( $throws );
		foreach( $function->getTriggers() as $trigger )
			$this->setTrigger( $trigger );
		foreach( $function->getLicenses() as $license )
			$this->setLicense( $license );

		//	@todo		parameters are missing
		return $this;
	}

	public function setCategory(){}

	/**
	 *	Sets function deprecation.
	 *	@access		public
	 *	@param		string			$string		Function deprecation
	 *	@return		self
	 */
	public function setDeprecation( string $string ): self
	{
		$this->deprecations[]	= $string;
		return $this;
	}

	public function setPackage(){}

	/**
	 *	Sets function link.
	 *	@access		public
	 *	@param		Parameter_		$parameter	Parameter data object
	 *	@return		self
	 */
	public function setParameter( Parameter_ $parameter ): self
	{
		$this->param[$parameter->getName()]	= $parameter;
		return $this;
	}

	/**
	 *	Sets functions parent file.
	 *	@access		public
	 *	@param		File_			$file		Function's parent file data object
	 *	@return		self
	 */
	public function setParent( $file ): self
	{
		if( !( $file instanceof File_ ) )
			throw new \InvalidArgumentException( 'Parent must be of Structure\\File_' );
		$this->parent	= $file;
		return $this;
	}

	/**
	 *	Sets functions return data object.
	 *	@access		public
	 *	@param		Return_			$return		Function's return data object
	 *	@return		self
	 */
	public function setReturn( Return_ $return ): self
	{
		$this->return	= $return;
		return $this;
	}

	/**
	 *	Sets method source code.
	 *	@access		public
	 *	@param		string			Method source code (multiline string)
	 *	@return		self
	 */
	public function setSourceCode( $string ): self
	{
		$this->sourceCode	= $string;
		return $this;
	}

	public function setThrows( Throws_ $throws ): self
	{
		$this->throws[]	= $throws;
		return $this;
	}

	/**
	 *	Sets function todo.
	 *	@access		public
	 *	@param		string			$string		Function todo string
	 *	@return		self
	 */
	public function setTodo( string $string ): self
	{
		$this->todos[]	= $string;
		return $this;
	}

	public function setTrigger( Trigger_ $trigger ): self
	{
		$this->triggers[]	= $trigger;
		return $this;
	}
}
