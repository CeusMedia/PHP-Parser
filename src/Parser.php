<?php
namespace CeusMedia\PhpParser;

use CeusMedia\PhpParser\Parser\Regular as RegularParser;
use CeusMedia\PhpParser\Parser\Reflection as ReflectionParser;
use CeusMedia\PhpParser\Structure\File_;

class Parser
{
	const STRATEGY_REGULAR		= 0;
	const STRATEGY_REFLECTION	= 1;

	protected $strategy		= 'Regular';

	public function __construct()
	{
	}

	public function parseFile( string $fileName ): File_
	{
		switch( $this->strategy ){
			case self::STRATEGY_REFLECTION:
				$parser	= new ReflectionParser();
				break;
			case self::STRATEGY_REGULAR:
			default:
				$parser	= new RegularParser();
				break;
		}
		return $parser->parseFile( $fileName, '' );
	}

	public function setStrategy( int $strategy ): self
	{
		$this->strategy	= $strategy;
		return $this;
	}
}
