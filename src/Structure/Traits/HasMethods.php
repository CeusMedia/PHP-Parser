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

use CeusMedia\PhpParser\Structure\Method_;
use DomainException;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait HasMethods
{
	/** @var	array		$methods		... */
	protected array $methods		= array();

	/**
	 *	Returns an interface method by its name.
	 *	@access		public
	 *	@param		string			$name		Method name
	 *	@return		Method_			Method data object
	 *	@throws		DomainException if method is not existing
	 */
	public function & getMethod( string $name ): Method_
	{
		if( isset( $this->methods[$name] ) )
			return $this->methods[$name];
		throw new DomainException( "Method '$name' is unknown" );
	}

	/**
	 *	Returns a method data object by its name.
	 *	@access		public
	 *	@param		string			$name		Method name
	 *	@return		Method_			Method data object
	 */
/*	public function & getMethodByName( string $name ): Method_
	{
		if( isset( $this->methods[$name] ) )
			return $this->methods[$name];
		throw new DomainException( "Method '$name' is unknown" );
	}*/

	/**
	 *	Returns a list of method data objects.
	 *	@access		public
	 *	@return		array<Method_>		List of method data objects
	 */
	public function getMethods( bool $withMagics = TRUE ): array
	{
		if( $withMagics )
			return $this->methods;
		$methods	= array();
		foreach( $this->methods as $method )
			if( !str_starts_with( $method->getName(), '__' ) )
				$methods[$method->getName()]	= $method;
		return $methods;
	}

	/**
	 *	Indicates whether this class/interface/trait defines methods.
	 *	@access		public
	 *	@return		bool			Flag: interface defines methods
	 */
	public function hasMethods(): bool
	{
		return count( $this->methods ) > 0;
	}

	/**
	 *	Sets a method.
	 *	@access		public
	 *	@param		Method_			$method		Method data object to set
	 *	@return		self
	 */
	public function setMethod( Method_ $method ): self
	{
		$this->methods[$method->getName()]	= $method;
		return $this;
	}
}
