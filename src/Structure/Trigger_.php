<?php
/**
 *	Function/Method Return Data Class.
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
 *	@copyright		2017-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

/**
 *	Function/Method Return Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2017-2024 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Trigger_
{
	protected ?string $condition	= NULL;
	protected string $key;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$key			Trigger key
	 *	@param		?string		$condition		Trigger condition
	 *	@return		void
	 */
	public function __construct( string $key, ?string $condition = NULL )
	{
		$this->key			= $key;
		$this->condition	= $condition;
	}

	/**
	 *	Returns condition of trigger.
	 *	@access		public
	 *	@return		?string		Trigger condition
	 */
	public function getCondition(): ?string
	{
		return $this->condition;
	}

	/**
	 *	Returns key of trigger.
	 *	@access		public
	 *	@return		string		Trigger key
	 */
	public function getKey(): string
	{
		return $this->key;
	}

/*	public function merge( Return_ $return )
	{
		if( $this->name != $return->getName() )
			throw new Exception( 'Not merge-able' );
		if( $return->getDescription() )
			$this->setDescription( $return->getDescription() );
		if( $return->getType() )
			$this->setType( $return->getType() );
		if( $return->getParent() )
			$this->setParent( $return->getParent() );
	}
*/
	/**
	 *	Sets condition of trigger.
	 *	@access		public
	 *	@param		string		$condition		Trigger condition
	 *	@return		self
	 */
	public function setCondition( string $condition ): self
	{
		$this->condition	= $condition;
		return $this;
	}

	/**
	 *	Sets key of trigger.
	 *	@access		public
	 *	@param		string		$key			Trigger key
	 *	@return		self
	 */
	public function setKey( string $key ): self
	{
		$this->key	= $key;
		return $this;
	}
}
