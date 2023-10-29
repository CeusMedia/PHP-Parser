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

use CeusMedia\PhpParser\Parser\Regular as RegularParser;
use CeusMedia\PhpParser\Parser\Reflection as ReflectionParser;
use CeusMedia\PhpParser\Structure\File_;
use RangeException;

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
class Parser
{
	const STRATEGY_REGULAR		= 0;
	const STRATEGY_REFLECTION	= 1;

	/** @var int<0,1> $strategy */
	protected int $strategy		= 0;

	public function __construct()
	{
	}

	public function parseFile( string $fileName ): File_
	{
		$parser	= match( $this->strategy ){
			self::STRATEGY_REFLECTION		=> new ReflectionParser(),
			self::STRATEGY_REGULAR			=> new RegularParser(),
		};
		return $parser->parseFile( $fileName, '' );
	}

	/**
	 *	@param		int<0,1>		$strategy
	 *	@return		self
	 */
	public function setStrategy( int $strategy ): self
	{
		if( !in_array( $strategy, [self::STRATEGY_REGULAR, self::STRATEGY_REFLECTION], TRUE ) )
			throw new RangeException( 'Invalid strategy' );
		$this->strategy	= $strategy;
		return $this;
	}
}
