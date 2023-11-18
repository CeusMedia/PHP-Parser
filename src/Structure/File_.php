<?php
/**
 *	File Data Class.
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
use CeusMedia\PhpParser\Structure\Traits\HasCopyright;
use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasLinks;
use CeusMedia\PhpParser\Structure\Traits\HasLicense;
use CeusMedia\PhpParser\Structure\Traits\HasNamespace;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;
use CeusMedia\PhpParser\Structure\Traits\HasTodos;
use CeusMedia\PhpParser\Structure\Traits\MaybeDeprecated;
use RuntimeException;

/**
 *	File Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class File_
{
	use HasNamespace, HasAuthors, HasDescription, HasLinks, HasLicense, HasCopyright,  HasVersion, HasTodos, MaybeDeprecated;

	/** @var	string|NULL		$unicode		... */
	public ?string $unicode;

	/** @var	string|NULL		$basename		... */
	protected ?string $basename		= NULL;

	/** @var	string|NULL		$pathname		... */
	protected ?string $pathname		= NULL;

	/** @var	string|NULL		$uri			... */
	protected ?string $uri			= NULL;

	/** @var	string|NULL		$category		... */
	protected ?string $category		= NULL;

	/** @var	string|NULL		$package		... */
	protected ?string $package		= NULL;

	/** @var	string|NULL		$subpackage		... */
	protected ?string $subpackage	= NULL;

/*	protected $usedClasses	= [];*/

	/** @var	array<Function_>		$functions		... */
	protected array $functions		= [];

	/** @var	array<Class_>		$classes		... */
	protected array $classes		= [];

	/** @var	array<Interface_>		$interfaces		... */
	protected array $interfaces		= [];

	/** @var	array<Trait_>		$traits			... */
	protected array $traits			= [];

	/** @var	string		$sourceCode		... */
	protected string $sourceCode	= '';


	public function addClass( Class_ $class ): self
	{
		$this->classes[$class->getName()]	= $class;
		return $this;
	}

	public function addInterface( Interface_ $interface ): self
	{
		$this->interfaces[$interface->getName()]	= $interface;
		return $this;
	}

	public function addTrait( Trait_ $trait ): self
	{
		$this->traits[$trait->getName()]	= $trait;
		return $this;
	}

	public function getBasename(): ?string
	{
		return $this->basename;
	}

	public function getCategory(): ?string
	{
		return $this->category;
	}

	public function & getClass( string $name ): Class_
	{
		if( isset( $this->classes[$name] ) )
			return $this->classes[$name];
		throw new RuntimeException( 'Class "'.$name.'" is unknown' );
	}

	/**
	 * @return array<string,Class_>
	 */
	public function getClasses(): array
	{
		return $this->classes;
	}

	public function getTraits(): array
	{
		return $this->traits;
	}

	public function & getFunction( string $name ): Function_
	{
		if( isset( $this->functions[$name] ) )
			return $this->functions[$name];
		throw new RuntimeException( 'Function "'.$name.'" is unknown' );
	}

	public function getFunctions(): array
	{
		return $this->functions;
	}

	public function getId(): string
	{
		$parts	= [];
		if( NULL !== $this->category )
			$parts[]	= $this->category;
		if( NULL !== $this->package )
			$parts[]	= $this->package;
		$parts[]	= $this->basename;
		return implode( "-", $parts );
	}

	public function & getInterface( string $name ): Interface_
	{
		if( isset( $this->interfaces[$name] ) )
			return $this->interfaces[$name];
		throw new RuntimeException( 'Interface "'.$name.'" is unknown' );
	}

	public function getInterfaces(): array
	{
		return $this->interfaces;
	}

	public function getPackage(): ?string
	{
		return $this->package;
	}

	public function getPathname(): ?string
	{
		return $this->pathname;
	}

	public function getSourceCode(): string
	{
		return $this->sourceCode;
	}

	public function getSubpackage(): ?string
	{
		return $this->subpackage;
	}

	public function getUri(): ?string
	{
		return $this->uri;
	}

	public function hasClasses(): bool
	{
		return count( $this->classes ) > 0;
	}

	public function hasFunctions(): bool
	{
		return count( $this->functions ) > 0;
	}

	public function hasInterfaces(): bool
	{
		return count( $this->interfaces ) > 0;
	}

	public function setBasename( string $string ): self
	{
		$this->basename	= $string;
		return $this;
	}

	public function setCategory( string $string ): self
	{
		$this->category	= trim( $string );
		return $this;
	}

	public function setFunction( Function_ $function ): self
	{
		$this->functions[$function->getName()]	= $function;
		return $this;
	}

	public function setPackage( string $string ): self
	{
		$this->package	= $string;
		return $this;
	}

	public function setPathname( string $string ): self
	{
		$this->pathname		= $string;
		return $this;
	}

	public function setSourceCode( string $string ): self
	{
		$this->sourceCode	= $string;
		return $this;
	}

	public function setSubpackage( string $string ): self
	{
		$this->subpackage	= $string;
		return $this;
	}

	public function setUri( string $uri ): self
	{
		$this->uri	= $uri;
		return $this;
	}
}
