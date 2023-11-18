<?php /** @noinspection PhpUnused */

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

use CeusMedia\PhpParser\Exception\MergeException;
use CeusMedia\PhpParser\Structure\Traits\HasAuthors;
use CeusMedia\PhpParser\Structure\Traits\HasCategory;
use CeusMedia\PhpParser\Structure\Traits\HasCopyright;
use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasLinks;
use CeusMedia\PhpParser\Structure\Traits\HasLicense;
use CeusMedia\PhpParser\Structure\Traits\HasLineInFile;
use CeusMedia\PhpParser\Structure\Traits\HasMethods;
use CeusMedia\PhpParser\Structure\Traits\HasName;
use CeusMedia\PhpParser\Structure\Traits\HasNamespace;
use CeusMedia\PhpParser\Structure\Traits\HasPackage;
use CeusMedia\PhpParser\Structure\Traits\HasParent;
use CeusMedia\PhpParser\Structure\Traits\HasTodos;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;
use CeusMedia\PhpParser\Structure\Traits\MaybeDeprecated;

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
	use HasNamespace;
	use HasAuthors;
	use HasCategory;
	use HasDescription;
	use HasMethods;
	use HasName;
	use HasParent;
	use HasLinks;
	use HasLicense;
	use HasCopyright;
	use HasLineInFile;
	use HasPackage;
	use HasVersion;
	use HasTodos;
	use MaybeDeprecated;

	/** @var	Interface_|string|NULL		$extends		... */
	protected Interface_|string|NULL $extends			= NULL;

	/** @var	array			$implementedBy		... */
	protected array $implementedBy	= [];

	/** @var	array			$extendedBy		... */
	protected array $extendedBy		= [];

	/** @var	array			$usedBy		... */
	protected array $usedBy			= [];

	/** @var	array			$composedBy		... */
	protected array $composedBy		= [];

	/** @var	array			$receivedBy		... */
	protected array $receivedBy		= [];

	/** @var	array			$returnedBy		... */
	protected array $returnedBy		= [];

	/**
	 *	Constructor, binding a File_.
	 *	@access		public
	 *	@param		string		$name		File with contains this interface
	 *	@return		void
	 */
	public function __construct( string $name )
	{
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

	public function getAbsoluteName(): string
	{
		return '\\'.$this->getNamespacedName();
	}

	public function getComposingClasses(): array
	{
		return $this->composedBy;
	}

	/**
	 * @return string|Interface_|NULL
	 */
	public function getExtendedInterface(): string|Interface_|null
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
		$parts	= [];
		if( NULL !== $this->category )
			$parts[]	= $this->category;
		if( NULL !== $this->package )
			$parts[]	= $this->package;
#		$parts[]	= $this->parent->getBasename();
		$parts[]	= str_replace( '\\', ':', $this->getNamespacedName() );
		return implode( "-", $parts );
	}

	public function getImplementingClasses(): array
	{
		return $this->implementedBy;
	}

	public function getNamespacedName(): string
	{
		$prefix	= NULL !== $this->namespace ? $this->namespace.'\\' : '';
		return $prefix.$this->name;
	}

	public function getReceivingClasses(): array
	{
		return $this->receivedBy;
	}

	public function getReturningClasses(): array
	{
		return $this->returnedBy;
	}

	public function getUsingClasses(): array
	{
		return $this->usedBy;
	}

	/**
	 *	@param		Interface_		$artefact
	 *	@return		self
	 *	@throws		MergeException
	 */
	public function merge( Interface_ $artefact ): self
	{
		if( $this->name != $artefact->getName() )
			throw new MergeException( 'Not merge-able' );
		if( NULL !== $artefact->getDescription() )
			$this->setDescription( $artefact->getDescription() );
		if( NULL !== $artefact->getSince() )
			$this->setSince( $artefact->getSince() );
		if( NULL !== $artefact->getVersion() )
			$this->setVersion( $artefact->getVersion() );
		foreach( $artefact->getCopyrights() as $copyright )
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

	public function setExtendedInterfaceName( string|Interface_|null $interface ): self
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
