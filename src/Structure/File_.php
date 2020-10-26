<?php
/**
 *	File Data Class.
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
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Structure\Traits\HasAuthors;
use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasLinks;
use CeusMedia\PhpParser\Structure\Traits\HasLicense;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;

/**
 *	File Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class File_
{
	use HasAuthors, HasDescription, HasLinks, HasLicense, HasVersion;

	protected $basename		= NULL;
	protected $pathname		= NULL;
	protected $uri			= NULL;

	protected $category		= NULL;
	protected $package		= NULL;
	protected $subpackage	= NULL;

	protected $todos		= array();
	protected $deprecations	= array();
/*	protected $usedClasses	= array();*/

	protected $functions	= array();
	protected $classes		= array();
	protected $interfaces	= array();
	protected $traits		= array();

	protected $sourceCode	= "";
	public $unicode;

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

	/**
	 *	@deprecated	seems to be unused
	 */
	public function addInterfaceName( $interfaceName ): self
	{
		$this->interfaces[$interfaceName]	= $interfaceName;
		return $this;
	}

	public function getBasename()
	{
		return $this->basename;
	}

	public function getCategory()
	{
		return $this->category;
	}

	public function & getClass( string $name ): Class_
	{
		if( isset( $this->classes[$name] ) )
			return $this->classes[$name];
		throw new \RuntimeException( 'Class "'.$name.'" is unknown' );
	}

	public function getClasses(): array
	{
		return $this->classes;
	}

	public function getTraits(): array
	{
		return $this->traits;
	}

	public function getDeprecations(): array
	{
		return $this->deprecations;
	}

	public function & getFunction( string $name ): Function_
	{
		if( isset( $this->functions[$name] ) )
			return $this->functions[$name];
		throw new \RuntimeException( 'Function "'.$name.'" is unknown' );
	}

	public function getFunctions(): array
	{
		return $this->functions;
	}

	public function getId(): string
	{
		$parts	= array();
		if( $this->category )
			$parts[]	= $this->category;
		if( $this->package )
			$parts[]	= $this->package;
		$parts[]	= $this->basename;
		return implode( "-", $parts );
	}

	public function & getInterface( $name ): Interface_
	{
		if( isset( $this->interfaces[$name] ) )
			return $this->interfaces[$name];
		throw new \RuntimeException( 'Interface "'.$name.'" is unknown' );
	}

	public function getInterfaces(): array
	{
		return $this->interfaces;
	}

	public function getPackage()
	{
		return $this->package;
	}

	public function getPathname(): string
	{
		return $this->pathname;
	}

	public function getSourceCode()
	{
		return $this->sourceCode;
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

	public function getUri(): string
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

	public function setDeprecation( string $string ): self
	{
		$this->deprecations[]	= $string;
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

	public function setTodo( string $string ): self
	{
		$this->todos[]	= $string;
		return $this;
	}

	public function setUri( string $uri ): self
	{
		$this->uri	= $uri;
		return $this;
	}
}
