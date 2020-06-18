<?php
require_once __DIR__.'/../vendor/autoload.php';
new UI_DevOutput;


$f	= new CeusMedia\PhpParser\Structure\File_();
print_m( $f );die;




use CeusMedia\PhpParser\Parser\Regular as Parser;

$path	= __DIR__.'/../src/';
$parser	= new Parser();
$result	= $parser->parseFile( $path.'Structure/Parameter.php', $path );

print_m( $result );
