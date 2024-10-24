<?php
declare(strict_types=1);

/**
 *	...
 *
 *	Copyright (c) 2020-2023 Christian Würker (ceusmedia.de)
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
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure\Traits;

use CeusMedia\PhpParser\Structure\Author_;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait HasAuthors
{
	/** @var	 Author_[]		$authors		... */
	protected array $authors			= [];

	/**
	 *	Returns list of author data objects.
	 *	@access		public
	 *	@return		Author_[]		List of author data objects
	 */
	public function getAuthors(): array
	{
		return $this->authors;
	}

	/**
	 *	Sets an author by author data object.
	 *	@access		public
	 *	@param		Author_			$author		Author data object
	 *	@return		self
	 */
	public function setAuthor( Author_ $author ): self
	{
		$this->authors[]	= $author;
		return $this;
	}
}
