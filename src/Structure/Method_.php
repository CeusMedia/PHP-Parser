<?php
/**
 *	Class Method Data Class.
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

/**
 *	Class Method Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@extends		Function_
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Method_ extends Function_
{
	protected $abstract		= FALSE;
	protected $access		= NULL;
	protected $final		= FALSE;
	protected $static		= FALSE;

	/**
	 *	Returns method access.
	 *	@access		public
	 *	@return		string
	 */
	public function getAccess(): ?string
	{
		return $this->access;
	}

	public function getParent()
	{
		if( !is_object( $this->parent ) )
			throw new \RuntimeException( 'Method has no related class. Parser Error' );
		return parent::getParent();
	}

	/**
	 *	Indicates whether method is abstract.
	 *	@access		public
	 *	@return		bool
	 */
	public function isAbstract(): bool
	{
		return (bool) $this->abstract;
	}

	/**
	 *	Indicates whether method is final.
	 *	@access		public
	 *	@return		bool
	 */
	public function isFinal(): bool
	{
		return (bool) $this->final;
	}

	/**
	 *	Indicates whether method is static.
	 *	@access		public
	 *	@return		bool
	 */
	public function isStatic(): bool
	{
		return (bool) $this->static;
	}

	public function merge( Function_ $method ): self
	{
		if( $this->name != $method->getName() )
			throw new \Exception( 'Not mergable' );
		if( $method->getAccess() )
			$this->setAccess( $method->getAccess() );
		if( $method->getParent() )
			$this->setParent( $method->getParent() );
		if( $method->isAbstract() )
			$this->setAbstract( $method->isAbstract() );
		if( $method->isFinal() )
			$this->setFinal( $method->isFinal() );
		if( $method->isStatic() )
			$this->setStatic( $method->isStatic() );
		return $this;
	}

	/**
	 *	Sets if method is abstract.
	 *	@access		public
	 *	@param		bool		$isAbstract		Flag: method is abstract
	 *	@return		void
	 */
	public function setAbstract( bool $isAbstract = TRUE ): self
	{
		$this->abstract	= (bool) $isAbstract;
		return $this;
	}

	/**
	 *	Sets method access.
	 *	@access		public
	 *	@param		string		$string			Method access
	 *	@return		void
	 */
	public function setAccess( string $string = 'public' ): self
	{
		$this->access	= $string;
		return $this;
	}

	/**
	 *	Sets if method is final.
	 *	@access		public
	 *	@param		bool		$isFinal		Flag: method is final
	 *	@return		self
	 */
	public function setFinal( bool $isFinal = TRUE ): self
	{
		$this->final	= (bool) $isFinal;
		return $this;
	}

	public function setParent( $classOrInterface ): self
	{
		if( !( $classOrInterface instanceof Interface_ ) )
			throw new \InvalidArgumentException( 'Parent must be of Structure\\Class_' );
		$this->parent	= $classOrInterface;
		return $this;
	}

	/**
	 *	Sets if method is static.
	 *	@access		public
	 *	@param		bool		$isStatic		Flag: method is static
	 *	@return		void
	 */
	public function setStatic( bool $isStatic = TRUE ): self
	{
		$this->static	= (bool) $isStatic;
		return $this;
	}
}
