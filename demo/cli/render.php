<?php
( @include_once __DIR__.'/../../vendor/autoload.php' ) or
	die( 'Please use composer to install required packages.'.PHP_EOL );

new UI_DevOutput;

use CeusMedia\PhpParser\Renderer;
use CeusMedia\PhpParser\Structure\Class_;
use CeusMedia\PhpParser\Structure\Interface_;
use CeusMedia\PhpParser\Structure\Author_;
use CeusMedia\PhpParser\Structure\Member_;
use CeusMedia\PhpParser\Structure\Method_;
use CeusMedia\PhpParser\Structure\Return_;
use CeusMedia\PhpParser\Structure\Parameter_;

try{
	$class	= (new Class_( 'Test' ))
		->setImplementedInterface( new Interface_( 'Serializable' ) )
		->setAbstract( TRUE )
		->setDescription( 'Test Class' )
		->setAuthor( new Author_( 'Hans Testmann', 'hans.testmann@outlook.com' ) )
		->setMember( ( new Member_( 'member1', 'string', 'First member of class' ) )
			->setAccess( 'protected' )
			->setStatic( TRUE )
		)
		->setMethod( ( new Method_( 'method1' ) )
			->setDescription( 'Add to integers.' )
			->setAccess( 'protected' )
			->setReturn( new Return_( 'int', 'Always integer' ) )
			->setParameter( new Parameter_( 'a', 'int', 'First integer' ) )
			->setParameter( new Parameter_( 'b', 'int', 'Second integer' ) )
			->setSourceCode( ['return $a + $b;'] )
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
