<?php
declare(strict_types=1);

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
 *	@copyright		2021-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure\Traits;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2021-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait MaybeFinal
{
	/** @var	bool		$final		... */
	protected bool $final		= FALSE;

	/**
	 *	Returns whether this structure is final.
	 *	@access		public
	 *	@return		boolean		Is final or not
	 */
	public function isFinal(): bool
	{
		return $this->final;
	}

	/**
	 *	Sets whether this structure is final.
	 *	@access		public
	 *	@param		bool		$final		Flag: is final
	 *	@return		self
	 */
	public function setFinal( bool $final ): self
	{
		$this->final	= $final;
		return $this;
	}
}
