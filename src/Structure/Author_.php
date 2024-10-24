<?php
declare(strict_types=1);

/**
 *	File/Class/Function/Method Author Data Class.
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
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Exception\MergeException;
use CeusMedia\PhpParser\Structure\Traits\HasName;

/**
 *	File/Class/Function/Method Author Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Author_
{
	use HasName;

	protected ?string $email	= NULL;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string			$name		Author name
	 *	@param		string|NULL		$email		Author email
	 *	@return		void
	 */
	public function __construct( string $name, ?string $email = NULL )
	{
		$this->setEmail( $email );
		$this->setName( $name );
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 *	@param		Author_		$author
	 *	@return		self
	 *	@throws		MergeException
	 */
	public function merge( Author_ $author ): self
	{
		if( $this->name != $author->name )
			throw new MergeException( 'Not merge-able' );
		if( NULL !== $author->getEmail() )
			$this->setEmail( $author->getEmail() );
		return $this;
	}

	public function setEmail( ?string $email ): self
	{
		$this->email	= $email;
		return $this;
	}
}
