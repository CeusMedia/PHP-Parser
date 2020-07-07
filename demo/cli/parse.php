<?php
require_once __DIR__.'/../../vendor/autoload.php';
new UI_DevOutput;

use CeusMedia\PhpParser\Parser\Regular as Parser;

$path	= realpath( __DIR__.'/../../src' ).'/';

class Tree
{
	public function index( $path ){
		$nodes	= array();
		$this->indexRecursive( $path, $nodes );
		return $nodes;
	}

	protected function indexRecursive( $path, &$nodes, $steps = array() ){
		$parser		= new Parser();
		$folder		= new FS_Folder( $path );
		$children	= $folder->index( FS::TYPE_FOLDER );
		foreach( $children as $child ){
			$nodes[$child->getName()]	= (object) array(
				'type'		=> 'folder',
				'folder'	=> $child,
				'nodes'		=> array(),
				'fullpath'	=> $child->getPathName(),
				'path'		=> $steps ? join( '/', $steps ) : '',
				'label'		=> $child->getName(),
			);
			$newPath	= $path.'/'.$child->getName();
			$newSteps	= array_merge( $steps, array( $child->getName() ) );
			$this->indexRecursive( $newPath, $child->nodes, $newSteps );
		}
		$children	= $folder->index( FS::TYPE_FILE );
		foreach( $children as $child ){
			$file	= $parser->parseFile( $child->getPathName(), '' );
			$nodes[$child->getName()]	= (object) array(
				'type'		=> 'file',
				'file'		=> $child,
				'fullpath'	=> $child->getPathName(),
				'path'		=> $steps ? join( '/', $steps ) : '',
				'label'		=> $child->getName(),
				'node'		=> array( 'classes' => $file->getClasses() ),
			);
		}
	}
}

/*$tree	= new Tree();
$nodes	= $tree->index( $path );
print_m( $nodes );die;*/

$nodes	= array();
$parser	= new Parser();
$result	= $parser->parseFile( $path.'Structure/Parameter_.php', $path );

remark( 'Methods:' );
print_m( current( $result->getClasses() )->getMethods() );

remark( 'Method: setType' );
$method	= current( $result->getClasses() )->getMethod( 'setType' );
print( '- Parameters:'.PHP_EOL );
foreach( $method->getParameters() as $paramKey => $paramData ){
	$paramType	= $paramData->getType();
	$paramDesc	= $paramData->getDescription();
	print( '  - ('.$paramType.') '.$paramKey.': '.$paramDesc.PHP_EOL );
}
print( '- Return:'.PHP_EOL );
print( '  - Type:'.$method->getReturn()->getType().PHP_EOL );
print( '  - Desc:'.$method->getReturn()->getDescription().PHP_EOL );
