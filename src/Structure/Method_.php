<?php
declare(strict_types=1);

/**
 *	Class Method Data Class.
 *
 *	Copyright (c) 2008-2024 Christian Würker (ceusmedia.de)
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
 *	@copyright		2015-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Exception\MergeException;
use CeusMedia\PhpParser\Structure\Traits\HasAccessibility;
use CeusMedia\PhpParser\Structure\Traits\HasParent;
use CeusMedia\PhpParser\Structure\Traits\MaybeAbstract;
use CeusMedia\PhpParser\Structure\Traits\MaybeFinal;
use CeusMedia\PhpParser\Structure\Traits\MaybeStatic;
use RuntimeException;

/**
 *	Class Method Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Method_ extends Function_
{
	use HasAccessibility;
	use HasParent;
	use MaybeFinal;
	use MaybeStatic;
	use MaybeAbstract;

	/**
	 *	@access		public
	 *	@param		Function_		$method		...
	 *	@return		static
	 *	@throws		MergeException
	 *	@noinspection PhpParameterNameChangedDuringInheritanceInspection
	 */
	public function merge( Function_ $method ): static
	{
		if( !$method instanceof Method_ )
			throw new \RuntimeException( 'Merge of method with function not allowed' );
		if( $this->name != $method->getName() )
			throw new MergeException( 'Not merge-able' );
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
}
