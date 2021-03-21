<?php
( @include_once __DIR__.'/../../vendor/autoload.php' ) or
	die( 'Please use composer to install required packages.'.PHP_EOL );

new UI_DevOutput;

use CeusMedia\PhpParser\Parser\Regular as Parser;

$path	= realpath( __DIR__.'/../../src' );

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
				'node'		=> array(
					'classes'		=> $file->getClasses(),
					'traits'		=> $file->getTraits(),
					'interfaces'	=> $file->getInterfaces(),
				),
			);
		}
	}
}
$tree	= new Tree();
$nodes	= $tree->index( $path );

print_m( $nodes );die;

$nodes	= array();
$parser	= new Parser();
$result	= $parser->parseFile( $path.'Structure/Parameter.php', $path );

remark( 'Methods:' );
print_m( current( $result->getClasses() )->getMethods() );
