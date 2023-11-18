<?php /** @noinspection PhpUnused */

/**
 *	Trait Data Class.
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
use CeusMedia\PhpParser\Structure\Traits\MaybeDeprecated;

/**
 *	Trait Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Trait_
{
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
	use MaybeDeprecated;

	/** @var	Trait_|string|NULL		$extends		... */
	protected Trait_|string|NULL $extends			= NULL;


	/** @var	array				$extendedBy		... */
	protected array $extendedBy		= [];

	/** @var	array				$usedBy		... */
	protected array $usedByClasses	= [];

	/** @var	array				$usedBy		... */
	protected array $usedByTraits	= [];

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$name		Short trait name
	 *	@return		void
	 */
	public function __construct( string $name )
	{
		$this->setName( $name );
	}

	public function getAbsoluteName(): string
	{
		return '\\'.$this->getNamespacedName();
	}

	/**
	 * @return string|Trait_|NULL
	 */
	public function getExtendedTrait(): string|Trait_|null
	{
		return $this->extends;
	}

	public function getExtendingTraits(): array
	{
		return $this->extendedBy;
	}

	/**
	 *	Returns the full ID of this trait (category_package_file_namespace:trait).
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

	public function getUsingClasses(): array
	{
		return $this->usedByClasses;
	}

	public function getUsingTraits(): array
	{
		return $this->usedByTraits;
	}

	/**
	 *	@param		Trait_		$artefact
	 *	@return		self
	 *	@throws		MergeException
	 */
	public function merge( Trait_ $artefact ): self
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

	public function setExtendedTrait( Trait_ $trait ): self
	{
		$this->extends	= $trait;
		return $this;
	}

	public function setExtendedTraitName( string|Trait_|null $trait ): self
	{
		$this->extends	= $trait;
		return $this;
	}

	public function setExtendingTrait_( Trait_ $trait ): self
	{
		$this->extendedBy[$trait->getName()]	= $trait;
		return $this;
	}

	public function setExtendingTraitName( string $trait ): self
	{
		$this->extendedBy[$trait]	= $trait;
		return $this;
	}

	public function setUsingClass( Class_ $class ): self
	{
		$this->usedByClasses[$class->getName()]	= $class;
		return $this;
	}

	public function setUsingClassName( string $className ): self
	{
		$this->usedByClasses[$className]	= $className;
		return $this;
	}

	public function setUsingTrait( Trait_ $trait ): self
	{
		$this->usedByTraits[$trait->getName()]	= $trait;
		return $this;
	}

	public function setUsingTraitName( string $traitName ): self
	{
		$this->usedByTraits[$traitName]	= $traitName;
		return $this;
	}
}
