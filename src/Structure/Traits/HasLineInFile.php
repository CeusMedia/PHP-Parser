<?php
namespace CeusMedia\PhpParser\Structure\Traits;

Trait HasLineInFile
{
	protected $line			= 0;

	/**
	 *	Returns line in code.
	 *	@access		public
	 *	@return		integer			Line number in code
	 */
	public function getLine(): int
	{
		return $this->line;
	}

	/**
	 *	Sets line in code.
	 *	@access		public
	 *	@param		integer			$number			Line number in code
	 *	@return		self
	 */
	public function setLine( int $number ): self
	{
		$this->line	= $number;
		return $this;
	}
}
