<?php
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
 *	@package		CeusMedia_PHP-Parser
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser;

use CeusMedia\PhpParser\Renderer\Regular as RegularRenderer;
use CeusMedia\PhpParser\Structure\File_;
use CeusMedia\PhpParser\Structure\Class_;

/**
 *	...
 *
 *	Copyright (c) 2020-2023 Christian Würker (ceusmedia.de)
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Renderer
{
	public const STRATEGY_REGULAR	= 0;

	protected int $strategy			= 0;

	public function __construct()
	{
	}

	public function renderClass( Class_ $class ): string
	{
		switch( $this->strategy ){
			case self::STRATEGY_REGULAR:
			default:
				$renderer	= new RegularRenderer();
				return $renderer->renderClass( $class );
		}
	}

	public function renderFile( File_ $file ): string
	{
		return '';
	}

	public function setStrategy( int $strategy ): self
	{
		$this->strategy	= $strategy;
		return $this;
	}
}
