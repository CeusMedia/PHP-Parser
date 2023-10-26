<?php
/**
 *	Function/Method Throws Data Class.
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

use CeusMedia\PhpParser\Structure\Traits\HasName;

/**
 *	Function/Method Throws Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Throws_
{
	use HasName;

	/** @var	string|NULL		$reason		... */
	protected ?string $reason	= NULL;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$name		Exception name
	 *	@param		?string		$reason		Exception reason
	 *	@return		void
	 */
	public function __construct( string $name, ?string $reason = NULL )
	{
		$this->setName( $name );
		$this->setReason( $reason );
	}

	/**
	 *	Returns exception reason.
	 *	@access		public
	 *	@return		string|NULL
	 */
	public function getReason(): ?string
	{
		return $this->reason;
	}

	public function merge( Throws_ $throws ): self
	{
		if( $this->name != $throws->getName() )
			throw new \Exception( 'Not merge-able' );
		if( NULL !== $throws->getReason() )
			$this->setReason( $throws->getReason() );
		return $this;
	}

	/**
	 *	Sets exception reason.
	 *	@access		public
	 *	@param		string|NULL		$reason		Exception reason
	 *	@return		self
	 */

	public function setReason( ?string $reason ): self
	{
		$this->reason	= $reason;
		return $this;
	}

	/**
	 *	Return this object as array.
	 *	@access		public
	 *	@return		array		This object as array
	 */
	public function toArray(): array
	{
		return array(
			'name'		=> $this->getName(),
			'reason'	=> $this->getReason(),
		);
	}
}
