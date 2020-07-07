<?php
namespace CeusMedia\PhpParser\Structure\Traits;

Trait HasVersion
{
	protected $since			= NULL;
	protected $version			= NULL;

	/**
	 *	Returns first version function occured.
	 *	@access		public
	 *	@return		mixed			First version function occured
	 */
	public function getSince(): ?string
	{
		return $this->since;
	}

	/**
	 *	Returns date of current version.
	 *	@access		public
	 *	@return		mixed			Date of current version
	 */
	public function getVersion(): ?string
	{
		return $this->version;
	}

	/**
	 *	Sets first version function occured.
	 *	@access		public
	 *	@param		string			$string		First version function occured
	 *	@return		self
	 */
	public function setSince( string $string ): self
	{
		$this->since	= $string;
		return $this;
	}

	/**
	 *	Sets date of current version.
	 *	@access		public
	 *	@param		string			$version		Date of current version
	 *	@return		self
	 */
	public function setVersion( string $version ): self
	{
		$this->version	= $version;
		return $this;
	}
}
