<?php
declare(strict_types=1);

/**
 *	File Function Data Class.
 *
 *	Copyright (c) 2008-2024 Christian Würker (ceusmedia.de)
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
 *	@copyright		2015-2024 Christian Würker
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
use CeusMedia\PhpParser\Structure\Traits\HasName;
use CeusMedia\PhpParser\Structure\Traits\HasPackage;
use CeusMedia\PhpParser\Structure\Traits\HasParent;
use CeusMedia\PhpParser\Structure\Traits\HasTodos;
use CeusMedia\PhpParser\Structure\Traits\HasVersion;
use CeusMedia\PhpParser\Structure\Traits\MaybeDeprecated;
use Exception;

/**
 *	File Function Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Function_
{
	use HasAuthors, HasCategory, HasDescription, HasName, HasPackage, HasParent, HasLinks, HasLicense, HasCopyright, HasLineInFile, HasVersion, HasTodos, MaybeDeprecated;

	/** @var	array		$throws				... */
	protected array $throws		= [];

	/** @var	array		$triggers			... */
	protected array $triggers		= [];

	/** @var	array		$param				... */
	protected array $param		= [];

	/** @var	Return_|NULL	$return			... */
	protected ?Return_ $return		= NULL;

	/** @var	array		$sourceCode		... */
	protected array $sourceCode	= [];

	public function __construct( string $name )
	{
		$this->setName( $name );
	}

	/**
	 *	Returns list of parameter data objects.
	 *	@access		public
	 *	@return		array			List of parameter data objects
	 */
	public function getParameters(): array
	{
		return $this->param;
	}

	/**
	 *	Returns return type as string or data object.
	 *	@access		public
	 *	@return		Return_|null		Return type as string or data object
	 */
	public function getReturn(): ?Return_
	{
		return $this->return;
	}

	/**
	 *	Returns method source code.
	 *	@access		public
	 *	@return		array			Method source code (multiline string)
	 */
	public function getSourceCode(): array
	{
		return $this->sourceCode;
	}

	/**
	 *	Returns list of thrown exceptions.
	 *	@access		public
	 *	@return		array			List of thrown exceptions
	 */
	public function getThrows(): array
	{
		return $this->throws;
	}

	/**
	 *	Returns list of triggers.
	 *	@access		public
	 *	@return		array			List of triggers
	 */
	public function getTriggers(): array
	{
		return $this->triggers;
	}

	/**
	 *	@param		Function_		$function		Function to merge with
	 *	@return		static
	 *	@throws		MergeException
	 */
	public function merge( Function_ $function ): static
	{
		if( $this->name != $function->getName() )
			throw new MergeException( 'Not merge-able' );
		if( NULL !== $function->getDescription() )
			$this->setDescription( $function->getDescription() );
		if( NULL !== $function->getSince() )
			$this->setSince( $function->getSince() );
		if( NULL !== $function->getVersion() )
			$this->setVersion( $function->getVersion() );
		if( NULL !== $function->getReturn() )
			$this->setReturn( $function->getReturn() );
		foreach( $function->getCopyrights() as $copyright )
			$this->setCopyright( $copyright );
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
		foreach( $function->getTriggers() as $trigger )
			$this->setTrigger( $trigger );
		foreach( $function->getLicenses() as $license )
			$this->setLicense( $license );

		//	@todo		parameters are missing
		return $this;
	}

	/**
	 *	Sets function link.
	 *	@access		public
	 *	@param		Parameter_		$parameter	Parameter data object
	 *	@return		static
	 */
	public function setParameter( Parameter_ $parameter ): static
	{
		$this->param[$parameter->getName()]	= $parameter;
		return $this;
	}

	/**
	 *	Sets functions return data object.
	 *	@access		public
	 *	@param		Return_			$return		Function's return data object
	 *	@return		static
	 */
	public function setReturn( Return_ $return ): static
	{
		$this->return	= $return;
		return $this;
	}

	/**
	 *	Sets method source code.
	 *	@access		public
	 *	@param		array			$soureCode	Method source code (multiline string)
	 *	@return		static
	 */
	public function setSourceCode( array $soureCode ): static
	{
		$this->sourceCode	= $soureCode;
		return $this;
	}

	public function setThrows( Throws_ $throws ): static
	{
		$this->throws[]	= $throws;
		return $this;
	}

	public function setTrigger( Trigger_ $trigger ): static
	{
		$this->triggers[]	= $trigger;
		return $this;
	}
}
