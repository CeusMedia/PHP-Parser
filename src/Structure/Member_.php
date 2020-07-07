<?php
/**
 *	Class Member Data Class.
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

/**
 *	Class Member Data Class.
 *	@category		Library
 *	@package		CeusMedia_Common_ADT_PHP
 *	@extends		Variable_
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Member_ extends Variable_
{
	protected $access		= NULL;
	protected $static		= FALSE;
	protected $default		= NULL;

	public function __toArray(): array
	{
		return [
			'name'			=> $this->getName(),
			'access'		=> $this->getAccess(),
			'static'		=> $this->isStatic(),
			'description'	=> $this->getDescription(),
		];
	}

	/**
	 *	Returns member access.
	 *	@access		public
	 *	@return		string
	 */
	public function getAccess(): ?string
	{
		return $this->access;
	}

	/**
	 *	Returns member default value.
	 *	@access		public
	 *	@return		string
	 */
	public function getDefault(): ?string
	{
		return $this->default;
	}

	/**
	 *	Returns parent Class or Interface Data Object.
	 *	@access		public
	 *	@return		Interface_	Parent Class or Interface Data Object
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 *	Indicates whether member is static.
	 *	@access		public
	 *	@return		bool
	 */
	public function isStatic(): bool
	{
		return (bool) $this->static;
	}

	public function merge( Variable_ $member ): self
	{
		parent::merge( $member );
#		remark( 'merging member: '.$member->getName() );
		if( $this->name != $member->getName() )
			throw new \Exception( 'Not mergable' );
		if( $member->getAccess() )
			$this->setAccess( $member->getAccess() );
		if( $member->getDefault() )
			$this->setDefault( $member->getDefault() );
		if( $member->isStatic() )
			$this->setAbstract( $member->isStatic() );
		return $this;
	}

	/**
	 *	Sets member access.
	 *	@access		public
	 *	@param		string			$string			Member access
	 *	@return		void
	 */
	public function setAccess( string $string = 'public' ): self
	{
		$this->access	= $string;
		return $this;
	}

	/**
	 *	Sets member default value.
	 *	@access		public
	 *	@param		string			$string			Member default value
	 *	@return		void
	 */
	public function setDefault( ?string $string ): self
	{
		$this->default	= $string;
		return $this;
	}

	/**
	 *	Sets parent Class or Interface Data Object.
	 *	@access		public
	 *	@param		Class_			$parent			Parent Class Data Object
	 *	@return		void
	 */
	public function setParent( $parent ): self
	{
		if( !( $parent instanceof Class_ ) && !( $parent instanceof Trait_ ) )
			throw new \InvalidArgumentException( 'Parent must be of Class_ or Trait_' );
		$this->parent	= $parent;
		return $this;
	}

	/**
	 *	Sets if member is static.
	 *	@access		public
	 *	@param		bool			$isStatic		Flag: member is static
	 *	@return		void
	 */
	public function setStatic( bool $isStatic = TRUE ): self
	{
		$this->static	= (bool) $isStatic;
		return $this;
	}
}
