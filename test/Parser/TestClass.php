<?php
/**
 *	Test Class File.
 *
 *	This is a Description.
 *
 *	@package		TestPackage
 *	@subpackage		TestSubPackage
 *	@extends		Alpha
 *	@implements		Beta
 *	@implements		Gamma
 *	@uses			Delta
 *	@uses			Epsilon
 *	@author			Test Writer 1 <test1@writer.tld>
 *	@author			Test Writer 2 <test2@writer.tld>
 *	@since			today
 *	@version		0.0.1
 *	@license		https://test.licence.org/test1.txt TestLicense 1
 *	@license		https://test.licence.org/test2.txt TestLicense 2
 *	@copyright		2007 Test Writer 1
 *	@copyright		2008 Test Writer 2
 *	@see			https://sub.domain.tld/1
 *	@see			https://sub.domain.tld/2
 *	@link			https://sub.domain.tld/test1
 *	@link			https://sub.domain.tld/test2
 */
/**
 *	Test Class.
 *
 *	This is a Description.
 *
 *	@package		TestPackage
 *	@subpackage		TestSubPackage
 *	@extends		Alpha
 *	@implements		Beta
 *	@implements		Gamma
 *	@uses			Delta
 *	@uses			Epsilon
 *	@author			Test Writer 1 <test1@writer.tld>
 *	@author			Test Writer 2 <test2@writer.tld>
 *	@since			today
 *	@version		0.0.1
 *	@license		https://test.licence.org/test1.txt TestLicense 1
 *	@license		https://test.licence.org/test2.txt TestLicense 2
 *	@copyright		2007 Test Writer 1
 *	@copyright		2008 Test Writer 2
 *	@see			https://sub.domain.tld/1
 *	@see			https://sub.domain.tld/2
 *	@link			https://sub.domain.tld/test1
 *	@link			https://sub.domain.tld/test2
 */
abstract class TestClass extends Alpha implements Beta, Gamma
{
	/**
	 * @var		string		$member1		First member
	 */
	public $member1;

	/**
	 *	Description Line 1.
	 *
	 *	Description Line 2.
	 *	Description Line 3.
	 *
	 *	@access		public
	 *	@param		ArrayObject	$object			An Array Object
	 *	@param		mixed		$reference		Reference of unknown Type
	 *	@param		array		$array			An Array
	 *	@param		mixed		$null			Always NULL
	 *	@return		void		nothing
	 *	@throws		LogicException				if something without logic is happening
	 *	@throws		BadMethodCallException		if a bad method is called
	 *	@author		Test Writer 5 <test5@writer.tld>
	 *	@author		Test Writer 6 <test6@writer.tld>
	 *	@version	3.2.1
	 *	@since		03.02.01
	 */
	abstract public function __construct( ArrayObject $object, &$reference, $array = [], $null = NULL );

	/**
	 *	@param		Object|NULL		$object
	 *	@return		void			nothing
	 */
	final public function testMethod( Object $object = NULL )
	{

	}

	static public function static1()
	{
	}

	final public static function static2(){
	}
}
/**
 *	Do something.
 *	@param		StringBuffer	$buffer		A String Buffer
 *	@param		string			$string		A String
 *	@param		bool			$bool		A Boolean
 *	@param		unknown			$unknown	not used
 *	@return		mixed			not specified right now
 *	@throws		Exception				if something went unexpectedly wrong
 *	@throws		RuntimeException		if something went wrong
 *	@author		Test Writer 3 <test3@writer.tld>
 *	@author		Test Writer 4 <test4@writer.tld>
 *	@version	1.2.3
 *	@since		01.02.03
 *	@stuff		crazy, man !
 */
function doSomething( StringBuffer $buffer, $string = "text", $bool = TRUE )
{

}
