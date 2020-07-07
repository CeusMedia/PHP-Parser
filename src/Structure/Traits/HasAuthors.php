<?php
namespace CeusMedia\PhpParser\Structure\Traits;

use CeusMedia\PhpParser\Structure\Author_;

Trait HasAuthors
{
	protected $authors		= array();

	/**
	 *	Returns list of author data objects.
	 *	@access		public
	 *	@return		array		List of author data objects
	 */
	public function getAuthors(): array
	{
		return $this->authors;
	}

	/**
	 *	Sets an author by author data object.
	 *	@access		public
	 *	@param		Author_			$author		Author data object
	 *	@return		self
	 */
	public function setAuthor( Author_ $author ): self
	{
		$this->authors[]	= $author;
		return $this;
	}
}
