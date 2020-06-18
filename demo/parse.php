<?php
require_once __DIR__.'/../vendor/autoload.php';
new UI_DevOutput;

use CeusMedia\PhpParser\Parser\Regular as Parser;

$path	= __DIR__.'/../src/';
$parser	= new Parser();
$result	= $parser->parseFile( $path.'Structure/Parameter.php', $path );

remark( 'Methods:' );
print_m( current( $result->getClasses() )->getMethods() );
