<?php
/**
 *	Function/Method Parameter Data Class.
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
 *	@since			0.3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasLineInFile;
use CeusMedia\PhpParser\Structure\Traits\HasName;

/**
 *	Function/Method Parameter Data Class.
 *	@category		Library
 *	@package		CeusMedia_Common_ADT_PHP
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@since			0.3
 *	@todo			Code Doc
 */
class Parameter_
{
	use HasDescription, HasName, HasLineInFile;

	protected $parent		= NULL;
	protected $cast			= NULL;
	protected $type			= NULL;
	protected $reference	= NULL;
	protected $default		= NULL;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string			$name			Parameter name
	 *	@param		string			$type			Parameter type
	 *	@param		string			$description	Parameter description
	 *	@return		void
	 */
	public function __construct( string $name, $type = NULL, ?string $description = NULL )
	{
		$this->setName( $name );
		if( !is_null( $type ) )
			$this->setType( $type );
		if( !is_null( $description ) )
			$this->setDescription( $description );
	}

	/**
	 *	Returns casted type of parameter.
	 *	@access		public
	 *	@return		mixed			Type string or data object
	 */
	public function getCast(): ?string
	{
		return $this->cast;
	}

	/**
	 *	Returns parameter default.
	 *	@access		public
	 *	@return		string			Parameter default
	 */
	public function getDefault(): ?string
	{
		return $this->default;
	}

	/**
	 *	Return parent container, an instance of ADT_PHP_Function or ADT_PHP_Class.
	 *	@access		public
	 *	@return		Function_	Parent container object, instance of ADT_PHP_Function or ADT_PHP_Class,
	 */
	public function getParent()
	{
		if( !is_object( $this->parent ) )
			throw new \RuntimeException( 'Parameter has no related function. Parser Error' );
		return $this->parent;
	}

	/**
	 *	Returns type of parameter.
	 *	@access		public
	 *	@return		mixed			Type string or data object
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 *	Indicates whether parameter is set by reference.
	 *	@access		public
	 *	@return		bool			Flag: Parameter is set by reference
	 */
	public function isReference(): bool
	{
		return (bool) $this->reference;
	}

	public function merge( Parameter_ $parameter ): self
	{
#		remark( "merging parameter: ".$parameter->getName() );
		if( $this->name != $parameter->getName() )
			throw new \Exception( 'Not mergable' );
		if( $parameter->getCast() )
			$this->setCast( $parameter->getCast() );
		if( $parameter->getDefault() )
			$this->setDefault( $parameter->getDefault() );
		if( $parameter->getDescription() )
			$this->setDescription( $parameter->getDescription() );
		if( $parameter->getType() )
			$this->setType( $parameter->getType() );
#		if( $parameter->getParent() )
#			$this->setParent( $parameter->getParent() );
		if( $parameter->isReference() )
			$this->setParent( $parameter->getParent() );

		// @todo		$reference	is missing
		return $this;
	}

	/**
	 *	Sets parameter casted type.
	 *	@access		public
	 *	@param		mixed			$type			Casted type string or data object
	 *	@return		void
	 */
	public function setCast( $type ): self
	{
		$this->cast	= $type;
		return $this;
	}

	/**
	 *	Sets parameter default.
	 *	@access		public
	 *	@param		string			$string			Parameter default
	 *	@return		void
	 */
	public function setDefault( string $string ): self
	{
		$this->default	= $string;
		return $this;
	}

	/**
	 *	Sets parent container, an instance of ADT_PHP_Function or ADT_PHP_Class.
	 *	@access		public
	 *	@param		Function_	$function		Parent container object, instance of ADT_PHP_Function or ADT_PHP_Class,
	 *	@return		void
	 */
	public function setParent( Function_ $function ): self
	{
		$this->parent	= $function;
		return $this;
	}

	public function setReference( bool $bool ): self
	{
		$this->reference	= (bool) $bool;
		return $this;
	}

	/**
	 *	Sets parameter type.
	 *	@access		public
	 *	@param		mixed			$type			Type string or data object
	 *	@return		self
	 */
	public function setType( $type ): self
	{
		$this->type	= $type;
		return $this;
	}
}
