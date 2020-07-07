<?php
namespace CeusMedia\PhpParser\Structure\Traits;

Trait HasName
{
	protected $name		= NULL;

	/**
	 *	Returns set name.
	 *	@access		public
	 *	@return		string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 *	Sets name.
	 *	@access		public
	 *	@param		string		$name		Name to set
	 *	@return		self
	 */
	public function setName( string $name ): self
	{
		$this->name	= $name;
		return $this;
	}
}
