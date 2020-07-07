<?php
/**
 *	Function/Method Return Data Class.
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

use CeusMedia\PhpParser\Structure\Traits\HasDescription;

/**
 *	Function/Method Return Data Class.
 *	@category		Library
 *	@package		CeusMedia_Common_ADT_PHP
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Return_
{
	use HasDescription;

	protected $parent		= NULL;
	protected $type			= NULL;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$type			Return type
	 *	@param		string		$description	Return description
	 *	@return		void
	 */
	public function __construct( $type = NULL, ?string $description = NULL )
	{
		$this->type			= $type;
		$this->description	= $description;
	}

	public function getParent()
	{
		if( !is_object( $this->parent ) )
			throw new \RuntimeException( 'Return has no related function. Parser Error' );
		return $this->parent;
	}

	/**
	 *	Returns type of return value.
	 *	@access		public
	 *	@return		void		Return type
	 */
	public function getType()
	{
		return $this->type;
	}

	public function merge( Return_ $return ): self
	{
		if( $this->name != $return->getName() )
			throw new \Exception( 'Not mergable' );
		if( $return->getDescription() )
			$this->setDescription( $return->getDescription() );
		if( $return->getType() )
			$this->setType( $return->getType() );
		if( $return->getParent() )
			$this->setParent( $return->getParent() );
		return $this;
	}

	public function setParent( Function_ $function ): self
	{
		$this->parent	= $function;
		return $this;
	}

	/**
	 *	Sets type of return value.
	 *	@access		public
	 *	@param		string		$type			Return type
	 *	@return		void
	 */
	public function setType( $type ): self
	{
		$this->type	= $type;
		return $this;
	}
}
