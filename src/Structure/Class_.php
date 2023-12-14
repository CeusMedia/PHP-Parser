<?php /** @noinspection PhpUnused */

/**
 *	Class Data Class.
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
use CeusMedia\PhpParser\Structure\Traits\CanExtendClass;
use CeusMedia\PhpParser\Structure\Traits\CanImplement;
use CeusMedia\PhpParser\Structure\Traits\CanUseTraits;
use CeusMedia\PhpParser\Structure\Traits\HasAuthors;
use CeusMedia\PhpParser\Structure\Traits\HasCategory;
use CeusMedia\PhpParser\Structure\Traits\HasCopyright;
use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasLicense;
use CeusMedia\PhpParser\Structure\Traits\HasLineInFile;
use CeusMedia\PhpParser\Structure\Traits\HasLinks;
use CeusMedia\PhpParser\Structure\Traits\HasMembers;
use CeusMedia\PhpParser\Structure\Traits\HasMethods;
use CeusMedia\PhpParser\Structure\Traits\HasName;
use CeusMedia\PhpParser\Structure\Traits\HasNamespace;
use CeusMedia\PhpParser\Structure\Traits\HasPackage;
use CeusMedia\PhpParser\Structure\Traits\HasParent;
use CeusMedia\PhpParser\Structure\Traits\HasTodos;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;
use CeusMedia\PhpParser\Structure\Traits\MaybeAbstract;
use CeusMedia\PhpParser\Structure\Traits\MaybeDeprecated;
use CeusMedia\PhpParser\Structure\Traits\MaybeFinal;

/**
 *	Class Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Class_
{
	use CanExtendClass;
	use CanImplement;
	use CanUseTraits;
	use HasNamespace;
	use HasAuthors;
	use HasCategory;
	use HasDescription;
	use HasMembers;
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
	use MaybeFinal;
	use MaybeAbstract;
	use MaybeDeprecated;

	/** @var	array				$extendedBy		... */
	protected array $extendedBy		= [];

	protected array $uses			= [];

	/** @var	array				$usedBy		... */
	protected array $usedBy			= [];

	/** @var	array				$composedBy		... */
	protected array $composedBy		= [];

	/** @var	array				$receivedBy		... */
	protected array $receivedBy		= [];

	/** @var	array				$returnedBy		... */
	protected array $returnedBy		= [];

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$name		Short class name
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

	public function getExtendingClasses(): array
	{
		return $this->extendedBy;
	}

	/**
	 *	Returns the full ID of this clas (category_package_file_namespace:class).
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

	public function getUsedClasses(): array
	{
		return $this->uses;
	}

	public function getUsingClasses(): array
	{
		return $this->usedBy;
	}

	public function isUsingClass( Class_ $class ): bool
	{
		/** @noinspection PhpUnusedLocalVariableInspection */
		foreach( $this->uses as $className => $usedClass )
			if( $class == $usedClass )
				return TRUE;
		return FALSE;
	}

	/**
	 *	@param		Class_		$artefact
	 *	@return		self
	 *	@throws		MergeException
	 */
	public function merge( Class_ $artefact ): self
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

		if( $artefact->isAbstract() )
			$this->setAbstract( $artefact->isAbstract() );
		if( $artefact->isFinal() )
			$this->setFinal( $artefact->isFinal() );

		foreach( $artefact->getUsedClasses() as $class )
			$this->setUsedClass( $class );

		//	@todo		members and interfaces missing
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

	public function setExtendingClass( Class_ $class ): self
	{
		$this->extendedBy[$class->getName()]	= $class;
		return $this;
	}

	public function setUsedClass( Class_ $class ): self
	{
		$this->uses[$class->getName()]	= $class;
		return $this;
	}

	public function setUsedClassName( string $className ): self
	{
		$this->uses[$className]	= $className;
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
