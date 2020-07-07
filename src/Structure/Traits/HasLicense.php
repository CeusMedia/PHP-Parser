<?php
namespace CeusMedia\PhpParser\Structure\Traits;

use CeusMedia\PhpParser\Structure\License_;

Trait HasLicense
{
	protected $licenses		= array();

	protected $copyright	= array();

	/**
	 *	Returns copyright notes.
	 *	@access		public
	 *	@return		array			Copyright notes
	 */
	public function getCopyright(): array
	{
		return $this->copyright;
	}

	/**
	 *	Returns list of licenses.
	 *	@access		public
	 *	@return		array			List of licenses
	 */
	public function getLicenses(): array
	{
		return $this->licenses;
	}

	/**
	 *	Sets copyright notes.
	 *	@access		public
	 *	@param		string			$copyright		Copyright notes
	 *	@return		self
	 */
	public function setCopyright( string $copyright ): self
	{
		$this->copyright[]	= $copyright;
		return $this;
	}

	/**
	 *	Sets function license.
	 *	@access		public
	 *	@param		string			$license		Function license
	 *	@return		self
	 */
	public function setLicense( License_ $license ): self
	{
		$this->licenses[]	= $license;
		return $this;
	}
}
