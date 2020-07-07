<?php
/**
 *	Interface Data Class.
 *
 *	Copyright (c) 2008-2020 Christian Würker (ceusmedia.de)
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *	@category		Library
 *	@package		CeusMedia_Common_ADT_PHP
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Structure\Traits\HasAuthors;
use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasName;
use CeusMedia\PhpParser\Structure\Traits\HasLinks;
use CeusMedia\PhpParser\Structure\Traits\HasLicense;
use CeusMedia\PhpParser\Structure\Traits\HasLineInFile;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;

/**
 *	Interface Data Class.
 *	@category		Library
 *	@package		CeusMedia_Common_ADT_PHP
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Interface_
{
	use HasAuthors, HasDescription, HasName, HasLinks, HasLicense, HasLineInFile, HasVersion;

	protected $parent			= NULL;

	protected $category			= NULL;
	protected $package			= NULL;
	protected $subpackage		= NULL;

	protected $final			= FALSE;

	protected $extends			= array();
	protected $implementedBy	= array();
	protected $extendedBy		= array();
	protected $usedBy			= array();
	protected $composedBy		= array();
	protected $receivedBy		= array();
	protected $returnedBy		= array();

	protected $todos			= array();
	protected $deprecations		= array();

	protected $methods			= array();

	/**
	 *	Constructor, binding a File_.
	 *	@access		public
	 *	@param		File_		$file		File with contains this interface
	 *	@return		void
	 */
	public function __construct( string $name = NULL )
	{
		if( !is_null( $name ) )
			$this->setName( $name );
	}

	public function addReceivingClass( Class_ $class ): self
	{
		$this->receivedBy[$class->getName()]	= $class;
		return $this;
	}

	public function addReceivingInterface( Interface_ $interface ): self
	{
		$this->receivedBy[$interface->getName()]	= $interface;
		return $this;
	}

	public function addReturningClass( Class_ $class ): self
	{
		$this->returnedBy[$class->getName()]	= $class;
		return $this;
	}

	public function addReturningInterface( Interface_ $interface ): self
	{
		$this->returnedBy[$interface->getName()]	= $interface;
		return $this;
	}

	/**
	 *	Returns category.
	 *	@return		string		Category name
	 */
	public function getCategory(): ?string
	{
		return $this->category;
	}

	public function getComposingClasses(): array
	{
		return $this->composedBy;
	}

	public function getDeprecations(): array
	{
		return $this->deprecations;
	}

	public function getExtendedInterface(): array
	{
		return $this->extends;
	}

	public function getExtendingInterfaces(): array
	{
		return $this->extendedBy;
	}

	/**
	 *	Returns the full ID of this interface (category_package_file_interface).
	 *	@access		public
	 *	@return		string
	 */
	public function getId(): string
	{
		$parts	= array();
		if( $this->category )
			$parts[]	= $this->category;
		if( $this->package )
			$parts[]	= $this->package;
#		$parts[]	= $this->parent->getBasename();
		$parts[]	= $this->name;
		return implode( "-", $parts );
	}

	public function getImplementingClasses(): array
	{
		return $this->implementedBy;
	}

	/**
	 *	Returns a interface method by its name.
	 *	@access		public
	 *	@param		string			$name		Method name
	 *	@return		Method_			Method data object
	 *	@throws		\RuntimeException if method is not existing
	 */
	public function & getMethod( string $name )
	{
		if( isset( $this->methods[$name] ) )
			return $this->methods[$name];
		throw new \RuntimeException( "Method '$name' is unknown" );
	}

	/**
	 *	Returns a list of method data objects.
	 *	@access		public
	 *	@return		array			List of method data objects
	 */
	public function getMethods( bool $withMagics = TRUE ): array
	{
		if( $withMagics )
			return $this->methods;
		$methods	= array();
		foreach( $this->methods as $method )
			if( substr( $method->getName(), 0, 2 ) !== "__" )
				$methods[$method->getName()]	= $method;
		return $methods;
	}

	/**
	 *	Returns full package name.
	 *	@access		public
	 *	@return		string			Package name
	 */
	public function getPackage(): ?string
	{
		return $this->package;
	}

	/**
	 *	Returns parent File Data Object.
	 *	@access		public
	 *	@return		File_			Parent File Data Object
	 *	@throws		\Exception		if not parent is set
	 */
	public function getParent()
	{
		if( !is_object( $this->parent ) )
			throw new \Exception( 'Parser Error: Interface has no related file' );
		return $this->parent;
	}

	public function getReceivingClasses(): array
	{
		return $this->receivedBy;
	}

	public function getReturningClasses(): array
	{
		return $this->returnedBy;
	}

	public function getSubpackage()
	{
		return $this->subpackage;
	}

	/**
	 *	Returns list of todos.
	 *	@access		public
	 *	@return		array			List of todos
	 */
	public function getTodos(): array
	{
		return $this->todos;
	}

	public function getUsingClasses(): array
	{
		return $this->usedBy;
	}

	/**
	 *	Indicates whether this interface defines methods.
	 *	@access		public
	 *	@return		bool			Flag: interface defines methods
	 */
	public function hasMethods(): array
	{
		return count( $this->methods ) > 0;
	}

	public function isFinal(): bool
	{
		return (bool) $this->final;
	}

	public function merge( Interface_ $artefact ): self
	{
		if( $this->name != $artefact->getName() )
			throw new \Exception( 'Not mergable' );
		if( $artefact->getDescription() )
			$this->setDescription( $artefact->getDescription() );
		if( $artefact->getSince() )
			$this->setSince( $artefact->getSince() );
		if( $artefact->getVersion() )
			$this->setVersion( $artefact->getVersion() );
		if( $artefact->getCopyright() )
			$this->setCopyright( $artefact->getCopyright() );
		if( $artefact->getReturn() )
			$this->setReturn( $artefact->getReturn() );

		foreach( $function->getAuthors() as $author )
			$this->setAuthor( $author );
		foreach( $function->getLinks() as $link )
			$this->setLink( $link );
		foreach( $function->getSees() as $see )
			$this->setSee( $see );
		foreach( $function->getTodos() as $todo )
			$this->setTodo( $todo );
		foreach( $function->getDeprecations() as $deprecation )
			$this->setDeprecation( $deprecation );
		foreach( $function->getThrows() as $throws )
			$this->setThrows( $throws );
		foreach( $function->getLicenses() as $license )
			$this->setLicense( $license );

		//	@todo		many are missing
		return $this;
	}

	/**
	 *	Sets category.
	 *	@param		string			$string		Category name
	 *	@return		self
	 */
	public function setCategory( string $string ): self
	{
		$this->category	= trim( $string );
		return $this;
	}

	public function setComposingClass( Class_ $class ): self
	{
		$this->composedBy[$class->getName()]	= $class;
		return $this;
	}

	public function setComposingClassName( string $className ): self
	{
		$this->composedBy[$className]	= $className;
		return $this;
	}

	public function setDeprecation( string $string ): self
	{
		$this->deprecations[]	= $string;
		return $this;
	}

	public function setExtendedInterface( Interface_ $interface ): self
	{
		$this->extends	= $interface;
		return $this;
	}

	public function setExtendedInterfaceName( $interface ): self
	{
		$this->extends	= $interface;
		return $this;
	}

	public function setExtendingInterface( Interface_ $interface ): self
	{
		$this->extendedBy[$interface->getName()]	= $interface;
		return $this;
	}

	public function setExtendingInterfaceName( string $interface ): self
	{
		$this->extendedBy[$interface]	= $interface;
		return $this;
	}

	public function setFinal( bool $isFinal = TRUE ): self
	{
		$this->final	= (bool) $isFinal;
		return $this;
	}

	public function setImplementingClass( Class_ $class ): self
	{
		$this->implementedBy[$class->getName()]	= $class;
		return $this;
	}

	public function setImplementingClassByName( string $class ): self
	{
		$this->implementedBy[$class]	= $class;
		return $this;
	}

	/**
	 *	Sets a method.
	 *	@access		public
	 *	@param		Method_			$method		Method to add to interface
	 *	@return		self
	 */
	public function setMethod( Method_ $method ): self
	{
		$this->methods[$method->getName()]	= $method;
		return $this;
	}

	/**
	 *	Sets package.
	 *	@param		string			$string		Package name
	 *	@return		self
	 */
	public function setPackage( string $string ): self
	{
		$string			= str_replace( array( "/", "::", ":", "." ), "_", $string );
		$this->package	= $string;
		return $this;
	}

	/**
	 *	Sets parent File Data Object.
	 *	@access		public
	 *	@param		File_			$parent		Parent File Data Object
	 *	@return		self
	 */
	public function setParent( File_ $parent ): self
	{
		$this->parent	= $parent;
		return $this;
	}

	/**
	 *	Sets subpackage.
	 *	@param		string			$string		Subpackage name
	 *	@return		void
	 */
	public function setSubpackage( string $string ): self
	{
		$this->subpackage	= $string;
		return $this;
	}

	/**
	 *	Sets todo notes.
	 *	@access		public
	 *	@param		string			$string		Todo notes
	 *	@return		void
	 */
	public function setTodo( string $string ): self
	{
		$this->todos[]	= $string;
		return $this;
	}

	public function setUsingClass( Class_ $class ): self
	{
		$this->usedBy[$class->getName()]	= $class;
		return $this;
	}

	public function setUsingClassName( string $className ): self
	{
		$this->usedBy[$className]	= $className;
		return $this;
	}
}
