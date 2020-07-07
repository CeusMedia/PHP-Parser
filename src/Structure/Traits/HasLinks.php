<?php
namespace CeusMedia\PhpParser\Structure\Traits;

Trait HasLinks
{
	protected $links			= array();
	protected $sees				= array();

	/**
	 *	Returns list of links.
	 *	@access		public
	 *	@return		array			List of links
	 */
	public function getLinks(): array
	{
		return $this->links;
	}

	/**
	 *	Returns list of see-also-references.
	 *	@access		public
	 *	@return		string		List of see-also-references
	 */
	public function getSees(): array
	{
		return $this->sees;
	}

	public function hasLinks(): bool
	{
		return count( $this->links ) > 0;
	}

	/**
	 *	Sets link.
	 *	@access		public
	 *	@param		string			$string		Link
	 *	@return		self
	 */
	public function setLink( string $string ): self
	{
		$this->links[]	= $string;
		return $this;
	}

	/**
	 *	Sets see-also-reference of variable.
	 *	@access		public
	 *	@param		string		$string			See-also-reference
	 *	@return		self
	 */
	public function setSee( string $string ): self
	{
		$this->sees[]	= $string;
		return $this;
	}
}
