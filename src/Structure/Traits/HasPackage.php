<?php
/**
 *	...
 *
 *	Copyright (c) 2023 Christian Würker (ceusmedia.de)
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
 *	@copyright		2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure\Traits;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait HasPackage
{
	/** @var	string|NULL		$package		... */
	protected ?string $package			= NULL;

	/** @var	string|NULL		$subpackage		... */
	protected ?string $subpackage		= NULL;

	/**
	 *	Returns full package name.
	 *	@access		public
	 *	@return		string|NULL			Package name
	 */
	public function getPackage(): ?string
	{
		return $this->package;
	}

	public function getSubpackage(): ?string
	{
		return $this->subpackage;
	}

	/**
	 *	Sets package.
	 *	@param		string			$string		Package name
	 *	@return		static
	 */
	public function setPackage( string $string ): static
	{
		$string			= str_replace( array( "/", "::", ":", "." ), "_", $string );
		$this->package	= $string;
		return $this;
	}

	/**
	 *	Sets subpackage.
	 *	@param		string			$string		Subpackage name
	 *	@return		self
	 */
	public function setSubpackage( string $string ): self
	{
		$this->subpackage	= $string;
		return $this;
	}
}
