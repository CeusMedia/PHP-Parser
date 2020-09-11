<?php
require_once __DIR__.'/../../vendor/autoload.php';
new UI_DevOutput;

use CeusMedia\PhpParser\Renderer;
use CeusMedia\PhpParser\Structure\Class_;
use CeusMedia\PhpParser\Structure\Interface_;
use CeusMedia\PhpParser\Structure\Author_;
use CeusMedia\PhpParser\Structure\Member_;

try{
	$class	= (new Class_( 'Test' ))
		->setImplementedInterface( new Interface_( 'Serializable' ) )
		->setAbstract( TRUE )
		->setDescription( 'Test Class' )
		->setAuthor( new Author_( 'Hans Testmann', 'hans.testmann@outlook.com' ) )
		->setMember( (new Member_( 'member1', 'string', 'First member of class' ) )
			->setAccess( 'protected' )
			->setStatic( TRUE )
		)
//		->setFinal( TRUE )
	;

	$renderer	= new Renderer();
	$code		= $renderer->renderClass( $class );
}
catch( Exception $e ){
	$exceptionView	= CLI_Exception_View::getInstance( $e )
		->render();
	print( $exceptionView );
	exit( 1 );
}


print( $code );
