<?php
/**
 *	Class Method Data Class.
 *
 *	Copyright (c) 2008-2023 Christian Würker (ceusmedia.de)
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
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Structure\Traits\HasAccessibility;
use CeusMedia\PhpParser\Structure\Traits\HasParent;
use CeusMedia\PhpParser\Structure\Traits\MaybeFinal;
use CeusMedia\PhpParser\Structure\Traits\MaybeStatic;

/**
 *	Class Method Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Method_ extends Function_
{
	use HasAccessibility;
	use HasParent;
	use MaybeFinal;
	use MaybeStatic;

	/** @var	bool		$abstract		... */
	protected bool $abstract		= FALSE;

	/**
	 *	Indicates whether method is abstract.
	 *	@access		public
	 *	@return		bool
	 */
	public function isAbstract(): bool
	{
		return $this->abstract;
	}

	/**
	 *	@access		public
	 *	@param		Function_		$method		...
	 *	@return		self
	 *	@noinspection PhpParameterNameChangedDuringInheritanceInspection
	 */
	public function merge( Function_ $method ): self
	{
		if( !$method instanceof Method_ )
			throw new \RuntimeException( 'Merge of method with function not allowed' );
		if( $this->name != $method->getName() )
			throw new \Exception( 'Not merge-able' );
		if( NULL !== $method->getAccess() )
			$this->setAccess( $method->getAccess() );
		if( NULL !== $method->getParent() )
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
	 *	@return		self
	 */
	public function setAbstract( bool $isAbstract = TRUE ): self
	{
		$this->abstract	= $isAbstract;
		return $this;
	}
}
