<?php
/**
 *	Class Variable Data Class.
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
use CeusMedia\PhpParser\Structure\Traits\HasLineInFile;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;

/**
 *	Class Variable Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Variable_
{
	use HasAuthors, HasDescription, HasName, HasLinks, HasLineInFile, HasVersion;

	protected $parent			= NULL;

	protected $type				= NULL;

	protected $since			= NULL;
	protected $version			= NULL;

	protected $todos			= array();
	protected $deprecations		= array();

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$name			Variable name
	 *	@param		mixed		$type			Variable type string or data object
	 *	@param		string		$description	Variable description
	 *	@return		void
	 */
	public function __construct( string $name, $type = NULL, ?string $description = NULL )
	{
		$this->setName( $name );
		if( !is_null( $type ) )
			$this->setType( $type );
		if( !is_null( $description ) )
			$this->setDescription( $description );
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
	 *	Returns parent File Data Object.
	 *	@access		public
	 *	@return		File_			Parent File Data Object
	 *	@throws		\Exception		if not parent is set
	 */
	public function getParent()
	{
		if( !is_object( $this->parent ) )
			throw new \Exception( 'Parser Error: variable has no related file' );
		return $this->parent;
	}

	/**
	 *	Returns list of todos.
	 *	@access		public
	 *	@return		string		List of todos
	 */
	public function getTodos(): array
	{
		return $this->todos;
	}

	/**
	 *	Returns type of parameter.
	 *	@access		public
	 *	@return		mixed		Type string or
	 */
	public function getType()
	{
		return $this->type;
	}

	public function merge( Variable_ $variable ): self
	{
#		remark( 'merging variable: '.$variable->getName() );
		if( $this->name != $variable->getName() )
			throw new \Exception( 'Not mergable' );
		if( $variable->getType() )
			$this->setType( $variable->getType() );
		if( $variable->getDescription() )
			$this->setDescription( $variable->getDescription() );
		if( $variable->getSince() )
			$this->setSince( $variable->getSince() );
		if( $variable->getVersion() )
			$this->setVersion( $variable->getVersion() );

		foreach( $variable->getAuthors() as $author )
			$this->setAuthor( $author );
		foreach( $variable->getLinks() as $link )
			$this->setLink( $link );
		foreach( $variable->getSees() as $see )
			$this->setSee( $see );
		foreach( $variable->getTodos() as $todo )
			$this->setTodo( $todo );
		foreach( $variable->getDeprecations() as $deprecation )
			$this->setDeprecation( $deprecation );
		return $this;
	}

	/**
	 *	Sets variable deprecation.
	 *	@access		public
	 *	@param		string			$string		Variable deprecation
	 *	@return		self
	 */
	public function setDeprecation( string $string ): self
	{
		$this->deprecations[]	= $string;
		return $this;
	}

	/**
	 *	Sets parent File Data Object.
	 *	@access		public
	 *	@param		File_		$parent		Parent File Data Object
	 *	@return		self
	 */
	public function setParent( ?File $parent ): self
	{
		$this->parent	= $parent;
		return $this;
	}

	/**
	 *	Sets todo.
	 *	@access		public
	 *	@param		string		$string			Todo string
	 *	@return		self
	 */
	public function setTodo( $string ): self
	{
		$this->todos[]	= $string;
		return $this;
	}

	/**
	 *	Sets parameter type.
	 *	@access		public
	 *	@param		mixed		$type			Type string or data object
	 *	@return		self
	 */
	public function setType( $type ): self
	{
		$this->type	= $type;
		return $this;
	}
}
