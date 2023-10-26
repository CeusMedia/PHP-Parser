<?php
/**
 *	Class Member Data Class.
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
use CeusMedia\PhpParser\Structure\Traits\MaybeStatic;

/**
 *	Class Member Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Member_ extends Variable_
{
	use HasAccessibility;
	use HasParent;
	use MaybeStatic;

	/** @var	string|NULL		$default		... */
	protected ?string $default			= NULL;

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
	 *	Returns member default value.
	 *	@access		public
	 *	@return		?string
	 */
	public function getDefault(): ?string
	{
		return $this->default;
	}

	/**
	 *	@param		Variable_		$member
	 *	@return		self
	 *	@noinspection PhpParameterNameChangedDuringInheritanceInspection
	 */
	public function merge( Variable_ $member ): self
	{
		if( !$member instanceof Member_ )
			throw new \RuntimeException( 'Merge of method with function not allowed' );
		parent::merge( $member );
#		remark( 'merging member: '.$member->getName() );
		if( $this->name != $member->getName() )
			throw new \Exception( 'Not merge-able' );
		if( $member->getAccess() )
			$this->setAccess( $member->getAccess() );
		if( $member->getDefault() )
			$this->setDefault( $member->getDefault() );
		if( $member->isStatic() )
			$this->setStatic( $member->isStatic() );
		return $this;
	}

	/**
	 *	Sets member default value.
	 *	@access		public
	 *	@param		?string			$string			Member default value
	 *	@return		self
	 */
	public function setDefault( ?string $string ): self
	{
		$this->default	= $string;
		return $this;
	}
}
