<?php
require_once '../../vendor/autoload.php';
new UI_DevOutput;

use CeusMedia\PhpParser\Parser;

$parser	= new Parser();
$parser->setStrategy( Parser::STRATEGY_REFLECTION );
$result	= $parser->parseFile( 'TestClass.php' );

print_m( $result->getClasses() );
