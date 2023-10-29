<?php
/**
 *	Function/Method Parameter Data Class.
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
 *	@since			0.3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasLineInFile;
use CeusMedia\PhpParser\Structure\Traits\HasParent;
use CeusMedia\PhpParser\Structure\Traits\HasName;
use CeusMedia\PhpParser\Structure\Traits\HasType;

/**
 *	Function/Method Parameter Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@since			0.3
 *	@todo			Code Doc
 */
class Parameter_
{
	use HasDescription, HasName, HasLineInFile, HasType, HasParent;

	/** @var	mixed			$cast			... */
	protected mixed $cast			= NULL;

	/** @var	bool			$reference		... */
	protected bool $reference		= FALSE;

	/** @var	string|NULL		$default		... */
	protected ?string $default		= NULL;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string			$name			Parameter name
	 *	@param		mixed			$type			Parameter type
	 *	@param		?string			$description	Parameter description
	 *	@return		void
	 */
	public function __construct( string $name, mixed $type = NULL, ?string $description = NULL )
	{
		$this->setName( $name );
		if( !is_null( $type ) )
			$this->setType( $type );
		if( !is_null( $description ) )
			$this->setDescription( $description );
	}

	/**
	 *	Returns cast type of parameter.
	 *	@access		public
	 *	@return		mixed		Type string or data object
	 */
	public function getCast(): mixed
	{
		return $this->cast;
	}

	/**
	 *	Returns parameter default.
	 *	@access		public
	 *	@return		string|NULL		Parameter default
	 */
	public function getDefault(): ?string
	{
		return $this->default;
	}

	/**
	 *	Indicates whether parameter is set by reference.
	 *	@access		public
	 *	@return		bool			Flag: Parameter is set by reference
	 */
	public function isReference(): bool
	{
		return $this->reference;
	}

	public function merge( Parameter_ $parameter ): self
	{
#		remark( "merging parameter: ".$parameter->getName() );
		if( $this->name != $parameter->getName() )
			throw new \Exception( 'Not merge-able' );
		if( NULL !== $parameter->getCast() )
			$this->setCast( $parameter->getCast() );
		if( NULL !== $parameter->getDefault() )
			$this->setDefault( $parameter->getDefault() );
		if( NULL !== $parameter->getDescription() )
			$this->setDescription( $parameter->getDescription() );
		if( NULL !== $parameter->getType() )
			$this->setType( $parameter->getType() );
#		if( $parameter->getParent() )
#			$this->setParent( $parameter->getParent() );
		if( $parameter->isReference() )
			$this->setParent( $parameter->getParent() );

		// @todo		$reference	is missing
		return $this;
	}

	/**
	 *	Sets parameter cast type.
	 *	@access		public
	 *	@param		mixed			$type			Cast type string or data object
	 *	@return		self
	 */
	public function setCast( mixed $type ): self
	{
		$this->cast	= $type;
		return $this;
	}

	/**
	 *	Sets parameter default.
	 *	@access		public
	 *	@param		string|NULL			$string			Parameter default
	 *	@return		self
	 */
	public function setDefault( ?string $string ): self
	{
		$this->default	= $string;
		return $this;
	}

	public function setReference( bool $bool ): self
	{
		$this->reference	= $bool;
		return $this;
	}
}
