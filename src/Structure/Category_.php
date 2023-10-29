<?php
/**
 *	...
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

use CeusMedia\PhpParser\Structure\Traits\HasParent;
use InvalidArgumentException;
use RuntimeException;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Category_
{
	use HasParent;

	protected array $categories	= array();
	protected array $classes		= array();
	protected array $interfaces	= array();
	protected array $packages		= array();
	protected string $label		= '';

	/**
	 *	Constructure, sets Label of Category if given.
	 *	@access		public
	 *	@param		?string		$label		Label of Category
	 *	@return		void
	 */
	public function __construct( ?string $label = NULL )
	{
		if( $label )
			$this->setLabel( $label );
	}

	/**
	 *	Relates a Class Object to this Category.
	 *	@access		public
	 *	@param		Class_		$class			Class Object to relate to this Category
	 *	@return		self
	 */
	public function addClass( Class_ $class ): self
	{
		$this->classes[$class->getName()]	= $class;
		return $this;
	}

	/**
	 *	Relates a Interface Object to this Category.
	 *	@access		public
	 *	@param		Interface_	$interface		Interface Object to relate to this Category
	 *	@return		self
	 */
	public function addInterface( Interface_ $interface ): self
	{
		$this->interfaces[$interface->getName()]	= $interface;
		return $this;
	}

	/**
	 *	@deprecated		not used yet
	 */
	public function getCategories(): array
	{
		return $this->categories;
	}

	/**
	 *	@deprecated	seems to be unused
	 */
	public function & getClassByName( $name ): Class_
	{
		if( isset( $this->classes[$name] ) )
			return $this->classes[$name];
		throw new RuntimeException( "Class '$name' is unknown" );
	}

	public function getClasses(): array
	{
		return $this->classes;
	}

	public function getId(): ?string
	{
#		remark( get_class( $this ).": ".$this->getLabel() );
		$parts	= array();
		$separator	= "_";
		if( $this->parent ){
			if( $parent = $this->parent->getId() ){
#				remark( $this->parent->getId() );
				if( get_class( $this->parent ) == '\\CeusMedia\\PhpParser\\Structure\\Category_' )
					$separator	= '-';
				$parts[]	= $parent;
			}
		}
		else
			return NULL;
		$parts[]	= $this->label;
		return implode( $separator, $parts );
	}

	/**
	 *	@deprecated	seems to be unused
	 */
	public function & getInterfaceByName( $name ): Interface_
	{
		if( isset( $this->interfaces[$name] ) )
			return $this->interfaces[$name];
		throw new RuntimeException( "Interface '$name' is unknown" );
	}

	public function getInterfaces(): array
	{
		return $this->interfaces;
	}

	public function getLabel(): string
	{
		return $this->label;
	}

	public function & getPackage( $name ): Package_
	{
		//  no package name given
		if( 0 === strlen( trim( $name ) ) )
			//  break: invalid package name
			throw new InvalidArgumentException( 'Package name cannot be empty' );
		//  set underscore as separator
		$parts		= explode( "_", str_replace( ".", "_", $name ) );
		//  Mainpackage name
		$main	= $parts[0];
		//  Mainpackage is not existing
		if( !array_key_exists( $main, $this->packages ) )
			//  break: unknown Mainpackage
			throw new RuntimeException( 'Package "'.$name.'" is unknown' );
		//  has no Subpackage, must be existing Mainpackage
		if( count( $parts ) == 1 )
			//  return Mainpackage
			return $this->packages[$main];
		//  Subpackage key
		$sub	= implode( "_", array_slice( $parts, 1 ) );
		//  ask for Subpackage in Mainpackage
		return $this->packages[$main]->getPackage( $sub );
	}

	/**
	 *	Returns Map of nested Packages.
	 *	@access		public
	 *	@return		array
	 */
	public function getPackages(): array
	{
		return $this->packages;
	}

	/**
	 *	Indicates whether Classes are registered in this Category.
	 *	@access		public
	 *	@return		bool
	 */
	public function hasClasses(): bool
	{
		return (bool) count( $this->classes );
	}

	/**
	 *	Indicates whether Interfaces are registered in this Category.
	 *	@access		public
	 *	@return		bool
	 */
	public function hasInterfaces(): bool
	{
		return (bool) count( $this->interfaces );
	}

	public function hasPackage( string $name ): bool
	{
		//  no package name given
		if( 0 === strlen( trim( $name ) ) )
			//  break: invalid package name
			throw new InvalidArgumentException( 'Package name cannot be empty' );
		//  set underscore as separator
		$parts		= explode( "_", str_replace( ".", "_", $name ) );
		//  Mainpackage name
		$main	= $parts[0];
		//  Mainpackage is not existing
		if( !array_key_exists( $main, $this->packages ) )
			//  break: unknown Mainpackage
			return FALSE;
		//  has no Subpackage
		if( count( $parts ) == 1 )
			//  must be existing Mainpackage
			return TRUE;
		//  Subpackage key
		$sub	= implode( "_", array_slice( $parts, 1 ) );
		//  ask for Subpackage in Mainpackage
		return $this->packages[$main]->hasPackage( $sub );
	}

	/**
	 *	Indicates whether Packages are registered in this Category.
	 *	@access		public
	 *	@return		bool
	 */
	public function hasPackages(): bool
	{
		return count( $this->packages ) > 0;
	}

	public function setLabel( string $string ): self
	{
		$this->label	= $string;
		return $this;
	}

	public function setPackage( string $name, Package_ $package ): self
	{
		//  no package name given
		if( 0 === strlen( trim( $name ) ) )
			//  break: invalid package name
			throw new InvalidArgumentException( 'Package name cannot be empty' );

		//  set underscore as separator
		$parts		= explode( "_", str_replace( ".", "_", $name ) );
		//  Mainpackage name
		$main	= $parts[0];
		//  has Subpackage
		if( count( $parts ) > 1 ){
			//  Subpackage key
			$sub	= implode( "_", array_slice( $parts, 1 ) );
			//  Mainpackage is not existing
			if( !array_key_exists( $main, $this->packages ) ){
				//  create empty Mainpackage for now
				$this->packages[$main]	= new Package_( $main );
				$this->packages[$main]->setParent( $this );
			}
			//  give Subpackage to Mainpackage
			$this->packages[$main]->setPackage( $sub, $package );
		}
		else{
			//  Package is not existing
			if( !array_key_exists( $name, $this->packages ) ){
				//  add Package
				$this->packages[$name]	= $package;
				$this->packages[$name]->setParent( $this );
			}
			else{
				//  iterate Classes in Package
				foreach( $package->getClasses() as $class )
					//  add Class to existing Package
					$this->packages[$name]->addClass( $class );
				//  iterate Interfaces in Package
				foreach( $package->getInterfaces() as $interface )
					//  add Interface to existing Package
					$this->packages[$name]->addInterface( $interface );
			}
//  iterate Files
#			foreach( $package->getFiles() as $file )
//  add File to existing Package
#				$this->packages[$name]->setFile( $file->basename, $file );
		}
		return $this;
	}
}
