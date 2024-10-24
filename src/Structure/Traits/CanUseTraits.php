<?php
declare(strict_types=1);

/**
 *	...
 *
 *	Copyright (c) 2020-2024 Christian Würker (ceusmedia.de)
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
 *	@copyright		2020-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure\Traits;

use CeusMedia\PhpParser\Structure\Trait_;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait CanUseTraits
{
	/** @var	array<string,Trait_|string>		$links		... */
	protected array $usedTraits		= [];

	/** @var	array		$sees		... */
	protected array $sees		= [];

	/**
	 *	Returns list of used traits in this class or trait.
	 *	@access		public
	 *	@return		array<string,Trait_|string>			List of links
	 */
	public function getUsedTraits(): array
	{
		return $this->usedTraits;
	}

	/**
	 * Indicates whether this class or trait uses traits.
	 * @return bool
	 */
	public function hasTraits(): bool
	{
		return 0 !== count( $this->usedTraits );
	}

	/**
	 *	@param		Trait_		$trait
	 *	@return		static
	 */
	public function setUsedTrait( Trait_ $trait ): static
	{
		$this->usedTraits[$trait->getName()]	= $trait;
		return $this;
	}

	/**
	 *	@param		string		$traitName
	 *	@return		static
	 */
	public function setUsedTraitName( string $traitName ): static
	{
		$this->usedTraits[$traitName]	= $traitName;
		return $this;
	}
}
