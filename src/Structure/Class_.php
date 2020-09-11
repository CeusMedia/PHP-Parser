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
 *	@package		CeusMedia_Common_ADT_PHP
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Structure\Traits\HasMembers;
use RuntimeException;

/**
 *	Class Data Class.
 *	@category		Library
 *	@package		CeusMedia_Common_ADT_PHP
 *	@extends		ADT_PHP_Interface
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Class_ extends Interface_
{
	use HasMembers;

	protected $abstract		= FALSE;
	protected $final		= FALSE;

	protected $implements	= array();
	protected $uses			= array();

	public function getExtendedClass()
	{
		return $this->extends;
	}

	public function getExtendingClasses()
	{
		return $this->extendedBy;
	}

	public function getImplementedInterfaces()
	{
		return $this->implements;
	}

	public function getUsedClasses(): array
	{
		return $this->uses;
	}

	public function isAbstract(): bool
	{
		return (bool) $this->abstract;
	}

	public function isFinal(): bool
	{
		return (bool) $this->final;
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
		foreach( $this->uses as $className => $class )
			if( $class == $class )
				return TRUE;
		return FALSE;
	}

	public function merge( Interface_ $artefact ): self
	{
		if( $this->name != $artefact->getName() )
			throw new \Exception( 'Not mergable' );
		if( $artefact->isAbstract() )
			$this->setAbstract( $artefact->isAbstract() );
		if( $artefact->getDefault() )
			$this->setDefault( $artefact->getDefault() );
		if( $artefact->isStatic() )
			$this->setAbstract( $artefact->isStatic() );

		foreach( $variable->getUsedClasses() as $artefact )
			$this->setUsedClass( $artefact );
		foreach( $variable->getUsedClasses() as $artefact )
			$this->setUsedClass( $artefact );

		//	@todo		members and interfaces missing
		return $this;
	}

	public function setAbstract( bool $isAbstract = TRUE ): self
	{
		$this->abstract	= (bool) $isAbstract;
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

	public function setFinal( bool $isFinal = TRUE ): self
	{
		if( $isFinal && $this->isAbstract() )
			throw new \Exception( 'Class cannot be abstract AND final' );
		$this->final	= (bool) $isFinal;
		return $this;
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
