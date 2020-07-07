<?php
namespace CeusMedia\PhpParser\Structure\Traits;

use CeusMedia\PhpParser\Structure\Member_;

Trait HasMembers
{
	protected $members		= array();
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
		throw new \RuntimeException( "Member '$name' is unknown" );
	}

	/**
	 *	Returns a list of member data objects.
	 *	@access		public
	 *	@return		array			List of member data objects
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
