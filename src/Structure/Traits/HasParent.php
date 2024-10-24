<?php
declare(strict_types=1);

/**
 *	...
 *
 *	Copyright (c) 2020-2024 Christian Würker (ceusmedia.de)
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
 *	@copyright		2021-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure\Traits;

use CeusMedia\PhpParser\Structure\Category_;
use CeusMedia\PhpParser\Structure\Class_;
use CeusMedia\PhpParser\Structure\File_;
use CeusMedia\PhpParser\Structure\Function_;
use CeusMedia\PhpParser\Structure\Interface_;
use CeusMedia\PhpParser\Structure\Method_;
use CeusMedia\PhpParser\Structure\Parameter_;
use CeusMedia\PhpParser\Structure\Trait_;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure_Traits
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2021-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
Trait HasParent
{
	/**
	 *	Returns parent structure object, if set.
	 *	@access		public
	 *	@return		object|NULL		Parent structure object
	 */
	public function getParent(): object|NULL
	{
		return $this->parent;
	}

	/** @var	object|NULL		$parent		... */
	protected $parent		= NULL;

	/**
	 *	Sets parent structure object, if available.
	 *	@access		public
	 *	@param		object|NULL		$parent		Parent structure object
	 *	@return		self
	 */
	public function setParent( object|null $parent ): self
	{
		$this->parent	= $parent;
		return $this;
	}
}
