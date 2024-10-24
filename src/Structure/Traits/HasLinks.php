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

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait HasLinks
{
	/** @var	array		$links		... */
	protected array $links		= [];

	/** @var	array		$sees		... */
	protected array $sees		= [];

	/**
	 *	Returns list of links.
	 *	@access		public
	 *	@return		array			List of links
	 */
	public function getLinks(): array
	{
		return $this->links;
	}

	/**
	 *	Returns list of see-also-references.
	 *	@access		public
	 *	@return		array		List of see-also-references
	 */
	public function getSees(): array
	{
		return $this->sees;
	}

	public function hasLinks(): bool
	{
		return count( $this->links ) > 0;
	}

	/**
	 *	Sets link.
	 *	@access		public
	 *	@param		string			$string		Link
	 *	@return		self
	 */
	public function setLink( string $string ): self
	{
		$this->links[]	= $string;
		return $this;
	}

	/**
	 *	Sets see-also-reference of variable.
	 *	@access		public
	 *	@param		string		$string			See-also-reference
	 *	@return		self
	 */
	public function setSee( string $string ): self
	{
		$this->sees[]	= $string;
		return $this;
	}
}
