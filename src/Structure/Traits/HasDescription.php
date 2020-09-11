<?php
namespace CeusMedia\PhpParser\Structure\Traits;

Trait HasDescription
{
	protected $description	= NULL;

	/**
	 *	Returns parameter description.
	 *	@access		public
	 *	@return		string			Parameter description
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 *	Sets variable description.
	 *	@access		public
	 *	@param		string			$string			Parameter description
	 *	@return		self
	 */
	public function setDescription( $string ): self
	{
		$this->description	= $string;
		return $this;
	}
}
