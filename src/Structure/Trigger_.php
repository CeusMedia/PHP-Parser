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
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2017-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

/**
 *	Function/Method Return Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2017-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Trigger_
{
	protected $condition	= NULL;
	protected $key			= NULL;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$type			Return type
	 *	@param		string		$description	Return description
	 *	@return		void
	 */
	public function __construct( string $key )
	{
		$this->key			= $key;
	}

	/**
	 *	Returns description of return value.
	 *	@access		public
	 *	@return		string		Return description
	 */
	public function getCondition(): ?string
	{
		return $this->condition;
	}

/*	public function getParent()
	{
		if( !is_object( $this->parent ) )
			throw new RuntimeException( 'Return has no related function. Parser Error' );
		return $this->parent;
	}

	public function merge( Return_ $return )
	{
		if( $this->name != $return->getName() )
			throw new Exception( 'Not mergable' );
		if( $return->getDescription() )
			$this->setDescription( $return->getDescription() );
		if( $return->getType() )
			$this->setType( $return->getType() );
		if( $return->getParent() )
			$this->setParent( $return->getParent() );
	}
*/
	/**
	 *	Sets description of return value.
	 *	@access		public
	 *	@param		string		$description	Return description
	 *	@return		self
	 */
	public function setCondition( $condition ): self
	{
		$this->condition	= $condition;
		return $this;
	}

/*	public function setParent( Function_ $function )
	{
		$this->parent	= $function;
	}
*/
	/**
	 *	Sets type of return value.
	 *	@access		public
	 *	@param		string		$type			Return type
	 *	@return		self
	 */
	public function setKey( $key ): self
	{
		$this->key	= $key;
		return $this;
	}
}
