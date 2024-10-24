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

use CeusMedia\PhpParser\Structure\Interface_;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait CanImplement
{
	/** @var	array<string,Interface_|string>		$links		... */
	protected array $implements		= [];

	/**
	 *	Returns list of used traits in this class or trait.
	 *	@access		public
	 *	@return		array<string,Interface_|string>			List of links
	 */
	public function getImplementedInterfaces(): array
	{
		return $this->implements;
	}

	public function implementsInterface( Interface_ $interface ): bool
	{
		/** @noinspection PhpUnusedLocalVariableInspection */
		foreach($this->implements as $interfaceName => $interfaceObject )
			if( $interface == $interfaceObject )
				return TRUE;
		return FALSE;
	}

	/**
	 * Indicates whether this class implements at least one interface.
	 * @return bool
	 */
	public function implementsInterfaces(): bool
	{
		return 0 !== count( $this->implements );
	}

	/**
	 * Alias for implementsInterface.
	 * @param Interface_ $interface
	 * @return bool
	 * @deprecated use implementsInterfaces instead
	 */
	public function isImplementingInterface( Interface_ $interface ): bool
	{
		return $this->implementsInterface( $interface );
	}

	/**
	 * Indicates whether this class implements at least one interface.
	 * Alias for implementsInterfaces.
	 * @return bool
	 * @deprecated use implementsInterfaces instead
	 */
	public function isImplementingInterfaces(): bool
	{
		return $this->implementsInterfaces();
	}

	/**
	 *	@param		Interface_		$interface
	 *	@return		static
	 */
	public function setImplementedInterface( Interface_ $interface ): static
	{
		$this->implements[$interface->getName()]	= $interface;
		return $this;
	}

	/**
	 *	@param		string		$interfaceName
	 *	@return		static
	 */
	public function setImplementedInterfaceName( string $interfaceName ): static
	{
		$this->implements[$interfaceName]	= $interfaceName;
		return $this;
	}
}
