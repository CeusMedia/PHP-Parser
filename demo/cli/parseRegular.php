<?php
( @include_once __DIR__.'/../../vendor/autoload.php' ) or
	die( 'Please use composer to install required packages.'.PHP_EOL );

use CeusMedia\PhpParser\Parser\Regular as Parser;

new CeusMedia\Common\UI\DevOutput;

$path	= realpath( __DIR__.'/../../src' ).'/';

$structure	= 'Structure/Parameter_';

$structure	= 'Structure/Method_';
$method		= 'merge';

$nodes		= array();
$parser		= new Parser();
$parameter	= $parser->parseFile( $path.$structure.'.php', $path );

remark( 'Parsing: '.$structure );

remark( 'Methods:' );
print_m( current( $parameter->getClasses() )->getMethods() );

remark( 'Method: '.$method );
$method	= current( $parameter->getClasses() )->getMethod( $method );
remark( '- Parameters:' );
foreach( $method->getParameters() as $paramKey => $paramData ){
	$paramType	= $paramData->getType();
	$paramDesc	= $paramData->getDescription();
	remark( '  - ('.$paramType.') '.$paramKey.': '.$paramDesc );
}
remark( '- Return:' );
remark( '  - Type:'.$method->getReturn()->getType() );
remark( '  - Desc:'.$method->getReturn()->getDescription() );
remark();


/*$tree	= new Tree();
$nodes	= $tree->index( $path );
print_m( $nodes );die;*/

class Tree
{
	public function index( $path ){
		$nodes	= array();
		$this->indexRecursive( $path, $nodes );
		return $nodes;
	}

	protected function indexRecursive( $path, &$nodes, $steps = array() ){
		$parser		= new Parser();
		$folder		= new CeusMedia\Common\FS\Folder( $path );
		$children	= $folder->index( CeusMedia\Common\FS::TYPE_FOLDER );
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
		$children	= $folder->index( CeusMedia\Common\FS::TYPE_FILE );
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
