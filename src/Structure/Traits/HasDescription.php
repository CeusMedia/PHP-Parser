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

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait HasDescription
{
	/** @var	string|NULL		$description		... */
	protected ?string $description	= NULL;

	/**
	 *	Returns parameter description.
	 *	@access		public
	 *	@return		string|NULL		Parameter description
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}

	/**
	 *	Sets variable description.
	 *	@access		public
	 *	@param		string|NULL		$string			Parameter description
	 *	@return		static
	 */
	public function setDescription( ?string $string ): static
	{
		$this->description	= $string;
		return $this;
	}
}
