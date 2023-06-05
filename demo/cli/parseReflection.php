<?php
( @include_once __DIR__.'/../../vendor/autoload.php' ) or
	die( 'Please use composer to install required packages.'.PHP_EOL );

use CeusMedia\PhpParser\Parser;

new CeusMedia\Common\UI\DevOutput;

$parser	= new Parser();
$parser->setStrategy( Parser::STRATEGY_REFLECTION );
$result	= $parser->parseFile( 'TestClass.php' );

print_m( $result->getClasses() );
