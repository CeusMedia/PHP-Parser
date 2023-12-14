<?php
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

use CeusMedia\PhpParser\Structure\Interface_;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait CanExtendInterface
{
	/** @var	Interface_|string|NULL		$extends		... */
	protected Interface_|string|NULL $extends				= NULL;

	/**
	 *	Returns list of used traits in this class or trait.
	 *	@access		public
	 *	@return		Interface_|string|NULL>					Extended class
	 */
	public function getExtendedInterface(): Interface_|string|NULL
	{
		return $this->extends;
	}

	public function extendsInterface( Interface_ $interface ): bool
	{
//		return $this->extends == $interface;
		return FALSE;
	}

	public function extendsInterfaceName( string $interfaceName ): bool
	{
//		if( $this->extends() )
//			return $this->extends->getName() === $interfaceName;
//		return FALSE;
		return FALSE;
	}

	/**
	 * Indicates whether this class implements at least one interface.
	 * @return bool
	 */
	public function extends(): bool
	{
		return NULL !== $this->extends;
	}


	/**
	 *	@param		Interface_		$interface
	 *	@return		static
	 */
	public function setExtendedClass( Interface_ $interface ): static
	{
		$this->extends	= $interface;
		return $this;
	}

	/**
	 *	@param		string		$interfaceName
	 *	@return		static
	 */
	public function setExtendedInterfaceName( string $interfaceName ): static
	{
		$this->extends	= $interfaceName;
		return $this;
	}
}
