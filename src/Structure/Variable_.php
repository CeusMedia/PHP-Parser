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
use CeusMedia\PhpParser\Structure\Traits\HasLinks;
use CeusMedia\PhpParser\Structure\Traits\HasLineInFile;
use CeusMedia\PhpParser\Structure\Traits\HasParent;
use CeusMedia\PhpParser\Structure\Traits\HasName;
use CeusMedia\PhpParser\Structure\Traits\HasTodos;
use CeusMedia\PhpParser\Structure\Traits\HasType;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;
use CeusMedia\PhpParser\Structure\Traits\MaybeDeprecated;

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
	use HasAuthors, HasDescription, HasName, HasParent, HasLinks, HasLineInFile, HasTodos, HasType, HasVersion, MaybeDeprecated;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$name			Variable name
	 *	@param		mixed		$type			Variable type string or data object
	 *	@param		?string		$description	Variable description
	 *	@return		void
	 */
	public function __construct( string $name, mixed $type = NULL, ?string $description = NULL )
	{
		$this->setName( $name );
		if( !is_null( $type ) )
			$this->setType( $type );
		if( !is_null( $description ) )
			$this->setDescription( $description );
	}

	public function merge( Variable_ $variable ): self
	{
#		remark( 'merging variable: '.$variable->getName() );
		if( $this->name != $variable->getName() )
			throw new \Exception( 'Not merge-able' );
		if( NULL !== $variable->getType() )
			$this->setType( $variable->getType() );
		if( NULL !== $variable->getDescription() )
			$this->setDescription( $variable->getDescription() );
		if( NULL !== $variable->getSince() )
			$this->setSince( $variable->getSince() );
		if( NULL !== $variable->getVersion() )
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
}
