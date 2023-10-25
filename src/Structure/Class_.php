<?php
/**
 *	Class Data Class.
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

use CeusMedia\PhpParser\Structure\Traits\HasMembers;
use CeusMedia\PhpParser\Structure\Traits\MaybeFinal;
use Exception;
use RuntimeException;

/**
 *	Class Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Class_ extends Interface_
{
	use HasMembers;
	use MaybeFinal;

	protected bool $abstract		= FALSE;

	protected array $implements		= array();
	protected array $uses			= array();

	public function getExtendedClass(): string|Interface_|null
	{
		return $this->extends;
	}

	public function getExtendingClasses(): array
	{
		return $this->extendedBy;
	}

	public function getImplementedInterfaces(): array
	{
		return $this->implements;
	}

	public function getUsedClasses(): array
	{
		return $this->uses;
	}

	public function isAbstract(): bool
	{
		return $this->abstract;
	}

	public function isImplementingInterface( Interface_ $interface ): bool
	{
		foreach( $this->implements as $interfaceName => $interfaceObject )
			if( $interface == $interfaceObject )
				return TRUE;
		return FALSE;
	}

	public function isUsingClass( Class_ $class ): bool
	{
		foreach( $this->uses as $className => $usedClass )
			if( $class == $usedClass )
				return TRUE;
		return FALSE;
	}

	/**
	 *	@param		Interface_		$artefact
	 *	@return		self
	 *	@throws		Exception
	 *	@todo		replace exception by specific merge exception
	 */
	public function merge( Interface_ $artefact ): self
	{
		if( !$artefact instanceof Class_ )
			throw new RuntimeException( 'Merge of method with function not allowed' );
		if( $this->name != $artefact->getName() )
			throw new Exception( 'Not merge-able' );
		if( $artefact->isAbstract() )
			$this->setAbstract( $artefact->isAbstract() );
		if( $artefact->isFinal() )
			$this->setFinal( $artefact->isFinal() );

		foreach( $artefact->getUsedClasses() as $class )
			$this->setUsedClass( $class );

		//	@todo		members and interfaces missing
		return $this;
	}

	public function setAbstract( bool $isAbstract = TRUE ): self
	{
		$this->abstract	= $isAbstract;
		return $this;
	}

	public function setExtendedClass( Class_ $class ): self
	{
		$this->extends	= $class;
		return $this;
	}

	public function setExtendedClassName( $class ): self
	{
		$this->extends	= $class;
		return $this;
	}

	public function setExtendedInterface( Interface_ $interface ): self
	{
		throw new RuntimeException( 'Class cannot extend an interface' );
	}

	public function setExtendingClass( Class_ $class ): self
	{
		$this->extendedBy[$class->getName()]	= $class;
		return $this;
	}

	public function setExtendingInterface( Interface_ $interface ): self
	{
		throw new RuntimeException( 'Interface cannot extend class' );
	}

	public function setImplementedInterface( Interface_ $interface ): self
	{
		$this->implements[$interface->name]	= $interface;
		return $this;
	}

	public function setImplementedInterfaceName( string $interfaceName ): self
	{
		$this->implements[$interfaceName]	= $interfaceName;
		return $this;
	}

	public function setImplementingClass( Class_ $class ): self
	{
		$this->implementedBy[$class->getName()]	= $class;
		return $this;
	}

	public function setImplementingClassName( string $className ): self
	{
		$this->implementedBy[$className]	= $className;
		return $this;
	}

	public function setUsedClass( Class_ $class ): self
	{
		$this->uses[$class->getName()]	= $class;
		return $this;
	}

	public function setUsedClassName( string $className ): self
	{
		$this->uses[$className]	= $className;
		return $this;
	}
}
