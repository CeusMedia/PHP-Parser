<?php
/**
 *	Interface Data Class.
 *
 *	Copyright (c) 2008-2023 Christian Würker (ceusmedia.de)
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
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Structure\Traits\HasAuthors;
use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasLinks;
use CeusMedia\PhpParser\Structure\Traits\HasLicense;
use CeusMedia\PhpParser\Structure\Traits\HasLineInFile;
use CeusMedia\PhpParser\Structure\Traits\HasName;
use CeusMedia\PhpParser\Structure\Traits\HasParent;
use CeusMedia\PhpParser\Structure\Traits\HasTodos;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;
use CeusMedia\PhpParser\Structure\Traits\MaybeDeprecated;
use Exception;
use RuntimeException;

/**
 *	Interface Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Interface_
{
	use HasAuthors, HasDescription, HasName, HasParent, HasLinks, HasLicense, HasLineInFile, HasVersion, HasTodos, MaybeDeprecated;

	/** @var	 string|NULL	$category		... */
	protected ?string $category			= NULL;

	/** @var	 string|NULL	$package		... */
	protected ?string $package			= NULL;

	/** @var	 string|NULL	$subpackage		... */
	protected ?string $subpackage		= NULL;

	/** @var	 Interface_|string|NULL		$extends		... */
	protected $extends			= NULL;

	/** @var	 array			$implementedBy		... */
	protected array $implementedBy	= array();

	/** @var	 array			$extendedBy		... */
	protected array $extendedBy		= array();

	/** @var	 array			$usedBy		... */
	protected array $usedBy			= array();

	/** @var	 array			$composedBy		... */
	protected array $composedBy		= array();

	/** @var	 array			$receivedBy		... */
	protected array $receivedBy		= array();

	/** @var	 array			$returnedBy		... */
	protected array $returnedBy		= array();

	/** @var	 array			$methods		... */
	protected array $methods			= array();

	/**
	 *	Constructor, binding a File_.
	 *	@access		public
	 *	@param		?string		$name		File with contains this interface
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

	public function getExtendedInterface()
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
	 *	Returns an interface method by its name.
	 *	@access		public
	 *	@param		string			$name		Method name
	 *	@return		Method_			Method data object
	 *	@throws		RuntimeException if method is not existing
	 */
	public function & getMethod( string $name ): Method_
	{
		if( isset( $this->methods[$name] ) )
			return $this->methods[$name];
		throw new RuntimeException( "Method '$name' is unknown" );
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

	public function getReceivingClasses(): array
	{
		return $this->receivedBy;
	}

	public function getReturningClasses(): array
	{
		return $this->returnedBy;
	}

	public function getSubpackage(): ?string
	{
		return $this->subpackage;
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
	public function hasMethods(): bool
	{
		return count( $this->methods ) > 0;
	}

	public function merge( Interface_ $artefact ): self
	{
		if( $this->name != $artefact->getName() )
			throw new Exception( 'Not merge-able' );
		if( $artefact->getDescription() )
			$this->setDescription( $artefact->getDescription() );
		if( $artefact->getSince() )
			$this->setSince( $artefact->getSince() );
		if( $artefact->getVersion() )
			$this->setVersion( $artefact->getVersion() );
		if( $artefact->getCopyright() )
			foreach( $artefact->getCopyright() as $copyright )
				$this->setCopyright( $copyright );

		foreach( $artefact->getAuthors() as $author )
			$this->setAuthor( $author );
		foreach( $artefact->getLinks() as $link )
			$this->setLink( $link );
		foreach( $artefact->getSees() as $see )
			$this->setSee( $see );
		foreach( $artefact->getTodos() as $todo )
			$this->setTodo( $todo );
		foreach( $artefact->getDeprecations() as $deprecation )
			$this->setDeprecation( $deprecation );
		foreach( $artefact->getLicenses() as $license )
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
	 *	Sets subpackage.
	 *	@param		string			$string		Subpackage name
	 *	@return		self
	 */
	public function setSubpackage( string $string ): self
	{
		$this->subpackage	= $string;
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
