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

use CeusMedia\PhpParser\Structure\Class_;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait CanExtendClass
{
	/** @var	Class_|string|NULL		$extends		... */
	protected Class_|string|NULL $extends				= NULL;

	/**
	 *	Returns list of used traits in this class or trait.
	 *	@access		public
	 *	@return		Class_|string|NULL>					Extended class
	 */
	public function getExtendedClass(): Class_|string|NULL
	{
		return $this->extends;
	}

	public function extendsClass( Class_ $class ): bool
	{
//		return $this->extends == $class;
		return FALSE;
	}

	public function extendsClassName( string $className ): bool
	{
//		if( $this->extends() )
//			return $this->extends->getName() === $className;
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
	 *	@param		Class_		$class
	 *	@return		static
	 */
	public function setExtendedClass( Class_ $class ): static
	{
		$this->extends	= $class;
		return $this;
	}

	/**
	 *	@param		string		$className
	 *	@return		static
	 */
	public function setExtendedClassName( string $className ): static
	{
		$this->extends	= $className;
		return $this;
	}
}
