<?php
declare( strict_types = 1 );

/**
 *	TestUnit of Parser\Regular.
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@since			10.08.2008
 *	@version		0.1
 */
namespace CeusMedia\PhpParserTest\Parser;

use PHPUnit\Framework\TestCase;
use CeusMedia\PhpParser\Parser\Regular as RegularParser;
use CeusMedia\PhpParser\Structure\File_;
use CeusMedia\PhpParser\Structure\Class_;
#use CeusMedia\PhpParser\Structure\Interface_;
#use CeusMedia\PhpParser\Structure\Trait_;
#use CeusMedia\PhpParser\Structure\Variable_;
#use CeusMedia\PhpParser\Structure\Member_;
use CeusMedia\PhpParser\Structure\Function_;
use CeusMedia\PhpParser\Structure\Method_;
use CeusMedia\PhpParser\Structure\Parameter_;
use CeusMedia\PhpParser\Structure\Author_;
use CeusMedia\PhpParser\Structure\License_;
use CeusMedia\PhpParser\Structure\Return_;
use CeusMedia\PhpParser\Structure\Throws_;

/**
 *	TestUnit of Parser\Regular.
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@since			10.08.2008
 *	@version		0.1
 *	@covers			\CeusMedia\PhpParser\Parser\Regular
 */
class RegularTest extends TestCase
{
	protected string $path;
	protected string $fileName;
	protected File_ $data;
	protected Function_ $function;
	protected Class_ $class;
	protected string $file;
	protected Method_ $method1;
	protected Method_ $method2;
	protected Method_ $method3;
	protected Method_ $method4;


	/**
	 *	Setup for every Test.
	 *	@access		public
	 *	@return		void
	 */
	public function setUp(): void
	{
		$this->path		= str_replace( "\\", '/', dirname( __FILE__ ) ).'/' ;
		$this->fileName	= $this->path.'TestClass.php';
		$parser			= new RegularParser();
		$this->data		= $parser->parseFile( $this->fileName, $this->path );

		/** @var Class_ $class */
		$class		= current( $this->data->getClasses() );
		/** @var Function_ $function */
		$function	= current( $this->data->getFunctions() );

		$this->class	= $class;
		$this->function	= $function;
		$this->file		= $this->data->getUri() ?? '';
//		print_m( $this->class->getMethods() );die;


		$methods		= $this->class->getMethods();
		$this->method1	= array_shift( $methods );
		$this->method2	= array_shift( $methods );
		$this->method3	= array_shift( $methods );
		$this->method4	= array_shift( $methods );
	}

	/**
	 *	Cleanup after every Test.
	 *	@access		public
	 *	@return		void
	 */
	public function tearDown(): void
	{
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFile1(): void
	{
		$parser	= new RegularParser();
		$data		= $parser->parseFile( $this->fileName, $this->path );
		$this->assertInstanceOf( File_::class, $data );

		$creation	= is_array( $data->getClasses() );
		$this->assertTrue(  $creation );

		$creation	= is_array( $data->getFunctions() );
		$this->assertTrue( $creation );

		$creation	= is_array( $data->getTodos() );
		$this->assertTrue( $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFile2(): void
	{
		$string		= '<?php\nphpinfo();\n?>';
		$fileName	= $this->path.'parser.php';
		file_put_contents( $fileName, $string );

		$parser		= new RegularParser();
		$data		= $parser->parseFile( $fileName, $this->path );
		@unlink( $fileName );

		$this->assertInstanceOf( File_::class, $data );
	}



	//  --  FILE DATA  --  //

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileData(): void
	{
		$this->assertInstanceOf( File_::class, $this->data );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataName(): void
	{
		$assertion	= 'TestClass.php';
		$creation	= $this->data->getBasename();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataUri(): void
	{
		$assertion	= $this->fileName;
		$creation	= $this->data->getUri();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataDescription(): void
	{
		$assertion	= "Test Class File.\n\nThis is a Description.";
		$creation	= $this->data->getDescription();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataPackage(): void
	{
		$assertion	= 'TestPackage';
		$creation	= $this->data->getPackage();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataAuthor(): void
	{
		$creation	= is_array( $this->data->getAuthors() );
		$this->assertTrue( $creation );

		$assertion	= array(
			new Author_( 'Test Writer 1', 'test1@writer.tld' ),
			new Author_( 'Test Writer 2', 'test2@writer.tld' ),
		);
		$creation	= $this->data->getAuthors();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataSince(): void
	{
		$assertion	= 'today';
		$creation	= $this->data->getSince();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataVersion(): void
	{
		$assertion	= '0.0.1';
		$creation	= $this->data->getVersion();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataCopyright(): void
	{
		$creation	= is_array( $this->data->getCopyrights() );
		$this->assertTrue( $creation );

		$assertion	= array(
			'2007 Test Writer 1',
			'2008 Test Writer 2',
		);
		$creation	= $this->data->getCopyrights();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataLicense(): void
	{
		$creation	= is_array( $this->data->getLicenses() );
		$this->assertTrue( $creation );

		$assertion	= array(
			new License_( 'TestLicense 1', 'https://test.licence.org/test1.txt' ),
			new License_( 'TestLicense 2', 'https://test.licence.org/test2.txt' ),
		);
		$creation	= $this->data->getLicenses();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataSee(): void
	{
		$creation	= is_array( $this->data->getSees() );
		$this->assertTrue( $creation );

		$assertion	= array(
			'https://sub.domain.tld/1',
			'https://sub.domain.tld/2',
		);
		$creation	= $this->data->getSees();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataLink(): void
	{
		$creation	= is_array( $this->data->getLinks() );
		$this->assertTrue( $creation );

		$assertion	= array(
			'https://sub.domain.tld/test1',
			'https://sub.domain.tld/test2',
		);
		$creation	= $this->data->getLinks();
		$this->assertEquals( $assertion, $creation );
	}



	//  --  FUNCTION DATA  --  //

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataFunction(): void
	{
		$creation	= is_array( $this->data->getFunctions() );
		$this->assertTrue( $creation );

		$assertion	= 'doSomething';
		$creation	= $this->function->getName();
		$this->assertEquals( $assertion, $creation );

		$this->assertEquals( 'not specified right now', $this->function->getReturn()?->getDescription() );

	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataFunctionDescription(): void
	{
		$assertion	= 'Do something.';
		$creation	= $this->function->getDescription();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataFunctionParam(): void
	{
		$creation	= is_array( $this->function->getParameters() );
		$this->assertTrue( $creation );

		$assertion	= 3;
		$creation	= count( $this->function->getParameters() );
		$this->assertEquals( $assertion, $creation );

		$parameters	= $this->function->getParameters();
		$param1	= array_shift( $parameters );
		$param2	= array_shift( $parameters );
		$param3	= array_shift( $parameters );

		$this->assertTrue( is_object( $param1 ) );
		$this->assertInstanceOf( Parameter_::class, $param1 );
		$this->assertEquals( 'StringBuffer', $param1->getCast() );
		$this->assertEquals( 'StringBuffer', $param1->getType() );
		$this->assertFalse( $param1->isReference() );
		$this->assertEquals( 'buffer', $param1->getName() );
		$this->assertNull( $param1->getDefault() );
		$this->assertEquals( 'A String Buffer', $param1->getDescription() );

		$this->assertTrue( is_object( $param2 ) );
		$this->assertInstanceOf( Parameter_::class, $param2 );
		$this->assertEquals( '', $param2->getCast() );
		$this->assertEquals( 'string', $param2->getType() );
		$this->assertFalse( $param2->isReference() );
		$this->assertEquals( 'string', $param2->getName() );
		$this->assertEquals( '"text"', $param2->getDefault() );
		$this->assertEquals( 'A String', $param2->getDescription() );

		$this->assertTrue( is_object( $param3 ) );
		$this->assertInstanceOf( Parameter_::class, $param3 );
		$this->assertEquals( '', $param3->getCast() );
		$this->assertEquals( 'bool', $param3->getType() );
		$this->assertFalse( $param3->isReference() );
		$this->assertEquals( 'bool', $param3->getName() );
		$this->assertEquals( 'TRUE', $param3->getDefault() );
		$this->assertEquals( 'A Boolean', $param3->getDescription() );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataFunctionReturn(): void
	{
		$this->assertInstanceOf( Return_::class, $this->function->getReturn() );
		$assertion	= new Return_( 'mixed', 'not specified right now' );
		$this->assertEquals( $assertion, $this->function->getReturn() );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataFunctionThrows(): void
	{
		$creation	= is_array( $this->function->getThrows() );
		$this->assertTrue( $creation );

		$assertion	= array(
			new Throws_( 'Exception', 'if something went unexpectedly wrong' ),
			new Throws_( 'RuntimeException', 'if something went wrong' )
		);
		$creation	= $this->function->getThrows();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataFunctionAuthor(): void
	{
		$creation	= is_array( $this->function->getAuthors() );
		$this->assertTrue( $creation );

		$assertion	= array(
			new Author_( 'Test Writer 3', 'test3@writer.tld' ),
			new Author_( 'Test Writer 4', 'test4@writer.tld' ),
		);
		$creation	= $this->function->getAuthors();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataFunctionSince(): void
	{
		$assertion	= '01.02.03';
		$creation	= $this->function->getSince();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileFileDataFunctionVersion(): void
	{
		$assertion	= '1.2.3';
		$creation	= $this->function->getVersion();
		$this->assertEquals( $assertion, $creation );
	}




	//  --  CLASS DATA  --  //

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassData(): void
	{
		$creation	= is_array( $this->data->getClasses() );
		$this->assertTrue( $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataName(): void
	{
		$assertion	= 'TestClass';
		$creation	= $this->class->getName();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataDescription(): void
	{
		$assertion	= "Test Class.\n\nThis is a Description.";
		$creation	= $this->class->getDescription();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataPackage(): void
	{
		$assertion	= 'TestPackage';
		$creation	= $this->class->getPackage();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataSubPackage(): void
	{
		$assertion	= 'TestSubPackage';
		$creation	= $this->class->getSubpackage();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataAbstract(): void
	{
		$creation	= $this->class->isAbstract();
		$this->assertTrue( $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataFinal(): void
	{
		$this->assertFalse( $this->class->isFinal() );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataExtends(): void
	{
		$assertion	= 'Alpha';
		$creation	= $this->class->getExtendedClass();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataImplements(): void
	{
		$creation	= is_array( $this->class->getImplementedInterfaces() );
		$this->assertTrue( $creation );

		$assertion	= array_combine( array( 'Beta', 'Gamma' ), array( 'Beta', 'Gamma' ) );
		$creation	= $this->class->getImplementedInterfaces();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataAuthor(): void
	{
		$creation	= is_array( $this->class->getAuthors() );
		$this->assertTrue( $creation );

		$assertion	= array(
			new Author_( 'Test Writer 1', 'test1@writer.tld' ),
			new Author_( 'Test Writer 2', 'test2@writer.tld' ),
		);
		$creation	= $this->class->getAuthors();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataSince(): void
	{
		$assertion	= 'today';
		$creation	= $this->class->getSince();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataVersion(): void
	{
		$assertion	= '0.0.1';
		$creation	= $this->class->getVersion();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataCopyright(): void
	{
		$creation	= is_array( $this->class->getCopyrights() );
		$this->assertTrue( $creation );

		$assertion	= array(
			'2007 Test Writer 1',
			'2008 Test Writer 2',
		);
		$creation	= $this->class->getCopyrights();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataLicense(): void
	{
		$creation	= is_array( $this->class->getLicenses() );
		$this->assertTrue( $creation );

		$assertion	= array(
			new License_( 'TestLicense 1', 'https://test.licence.org/test1.txt' ),
			new License_( 'TestLicense 2', 'https://test.licence.org/test2.txt' ),
		);
		$creation	= $this->class->getLicenses();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataSee(): void
	{
		$creation	= is_array( $this->class->getSees() );
		$this->assertTrue( $creation );

		$assertion	= array(
			'https://sub.domain.tld/1',
			'https://sub.domain.tld/2',
		);
		$creation	= $this->class->getSees();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataLink(): void
	{
		$creation	= is_array( $this->class->getLinks() );
		$this->assertTrue( $creation );

		$assertion	= array(
			'https://sub.domain.tld/test1',
			'https://sub.domain.tld/test2',
		);
		$creation	= $this->class->getLinks();
		$this->assertEquals( $assertion, $creation );
	}






	//  --  METHOD DATA  --  //

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethod()
	{
		$creation	= is_array( $this->class->getMethods() );
		$this->assertTrue( $creation );

		$assertion	= '__construct';
		$creation	= $this->method1->getName();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethodAbstract()
	{
		$creation	= $this->method1->isAbstract();
		$this->assertTrue( $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethodFinal()
	{
		$creation	= $this->method1->isFinal();
		$this->assertFalse( $creation );

		$creation	= $this->method2->isFinal();
		$this->assertTrue( $creation );

		$creation	= $this->method3->isFinal();
		$this->assertFalse( $creation );

		$creation	= $this->method4->isFinal();
		$this->assertTrue( $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethodStatic()
	{
		$creation	= $this->method1->isStatic();
		$this->assertFalse( $creation );

		$creation	= $this->method2->isStatic();
		$this->assertFalse( $creation );

		$creation	= $this->method3->isStatic();
		$this->assertTrue( $creation );

		$creation	= $this->method4->isStatic();
		$this->assertTrue( $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethodDescription()
	{
		$assertion	= "Description Line 1.\n\nDescription Line 2.\nDescription Line 3.";
		$creation	= $this->method1->getDescription();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethodAccess()
	{
		$assertion	= 'public';
		$creation	= $this->method1->getAccess();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethodParam()
	{
		$creation	= is_array( $this->method1->getParameters() );
		$this->assertTrue( $creation );

		$assertion	= 4;
		$creation	= count( $this->method1->getParameters() );
		$this->assertEquals( $assertion, $creation );

		$parameters	= $this->method1->getParameters();
		$param1	= array_shift( $parameters );
		$param2	= array_shift( $parameters );
		$param3	= array_shift( $parameters );
		$param4	= array_shift( $parameters );

		$this->assertTrue( is_object( $param1 ) );
		$this->assertInstanceOf( Parameter_::class, $param1 );
		$this->assertFalse( $param1->isReference() );
		$this->assertEquals( 'object', $param1->getName() );
		$this->assertEquals( 'ArrayObject', $param1->getType() );
		$this->assertEquals( 'ArrayObject', $param1->getCast() );
		$this->assertNull( $param1->getDefault() );
		$this->assertEquals( 'An Array Object', $param1->getDescription() );

		$this->assertTrue( is_object( $param2 ) );
		$this->assertInstanceOf( Parameter_::class, $param2 );
		$this->assertTrue( $param2->isReference() );
		$this->assertEquals( 'reference', $param2->getName() );
		$this->assertEquals( 'mixed', $param2->getType() );
		$this->assertNull( $param2->getCast() );
		$this->assertNull( $param2->getDefault() );
		$this->assertEquals( 'Reference of unknown Type', $param2->getDescription() );

		$this->assertTrue( is_object( $param3 ) );
		$this->assertInstanceOf( Parameter_::class, $param3 );
		$this->assertFalse( $param3->isReference() );
		$this->assertEquals( 'array', $param3->getName() );
		$this->assertEquals( 'array', $param3->getType() );
		$this->assertNull( $param3->getCast() );
		$this->assertEquals( '[]', $param3->getDefault() );
		$this->assertEquals( 'An Array', $param3->getDescription() );

		$this->assertTrue( is_object( $param4 ) );
		$this->assertInstanceOf( Parameter_::class, $param4 );
		$this->assertFalse( $param4->isReference() );
		$this->assertEquals( 'null', $param4->getName() );
		$this->assertEquals( 'mixed', $param4->getType() );
		$this->assertNull( $param4->getCast() );
		$this->assertEquals( 'NULL', $param4->getDefault() );
		$this->assertEquals( 'Always NULL', $param4->getDescription() );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethod1Return()
	{
		$this->assertInstanceOf( Return_::class, $this->method1->getReturn() );
		$assertion	= new Return_( 'void', 'nothing' );
		$assertion->setParent( $this->method1 );
		$creation	= $this->method1->getReturn();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethodThrows()
	{
		$creation	= is_array( $this->method1->getThrows() );
		$this->assertTrue( $creation );

		$assertion	= array(
			new Throws_( 'LogicException', 'if something without logic is happening' ),
			new Throws_( 'BadMethodCallException', 'if a bad method is called' ),
		);
		$creation	= $this->method1->getThrows();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethodAuthor()
	{
		$creation	= is_array( $this->method1->getAuthors() );
		$this->assertTrue( $creation );

		$assertion	= array(
			new Author_( 'Test Writer 5', 'test5@writer.tld' ),
			new Author_( 'Test Writer 6', 'test6@writer.tld' )
		);
		$creation	= $this->method1->getAuthors();
		$this->assertEquals( $assertion, $creation );
	}

	/**
	 *	Tests Method 'parseFile'.
	 *	@access		public
	 *	@return		void
	 */
	public function testParseFileClassDataMethodSince()
	{
		$assertion	= '03.02.01';
		$creation	= $this->method1->getSince();
		$this->assertEquals( $assertion, $creation );
	}
}
