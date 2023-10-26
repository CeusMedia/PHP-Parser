<?php
/**
 *	...
 *
 *	Copyright (c) 2020-2023 Christian Würker (ceusmedia.de)
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
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure\Traits;

use CeusMedia\PhpParser\Structure\Member_;
use DomainException;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait HasMembers
{
	/** @var	array		$members		... */
	protected array $members		= array();

	/**
	 *	Returns a member data object by its name.
	 *	@access		public
	 *	@param		string			$name		Member name
	 *	@return		Member_			Member data object
	 */
	public function & getMemberByName( $name )
	{
		if( isset( $this->members[$name] ) )
			return $this->members[$name];
		throw new DomainException( "Member '$name' is unknown" );
	}

	/**
	 *	Returns a list of member data objects.
	 *	@access		public
	 *	@return		array<Member_>		List of member data objects
	 */
	public function getMembers(): array
	{
		return $this->members;
	}

	/**
	 *	Sets a member.
	 *	@access		public
	 *	@param		Member_			$member		Member data object to set
	 *	@return		self
	 */
	public function setMember( Member_ $member ): self
	{
		$this->members[$member->getName()]	= $member;
		return $this;
	}
}
