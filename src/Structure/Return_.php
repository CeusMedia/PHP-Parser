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
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure;

use CeusMedia\PhpParser\Structure\Traits\HasDescription;
use CeusMedia\PhpParser\Structure\Traits\HasParent;
use CeusMedia\PhpParser\Structure\Traits\HasType;

/**
 *	Function/Method Return Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Return_
{
	use HasDescription, HasType, HasParent;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$type			Return type
	 *	@param		string		$description	Return description
	 *	@return		void
	 */
	public function __construct( $type = NULL, ?string $description = NULL )
	{
		$this->setType( $type );
		$this->setDescription( $description );
	}

	public function merge( Return_ $return ): self
	{
		if( NULL !== $return->getDescription() )
			$this->setDescription( $return->getDescription() );
		if( NULL !== $return->getType() )
			$this->setType( $return->getType() );
		if( NULL !== $return->getParent() )
			$this->setParent( $return->getParent() );
		return $this;
	}

	/**
	 *	Return this object as array.
	 *	@access		public
	 *	@return		array		This object as array
	 */
	public function toArray(): array
	{
		return array(
			'type'			=> $this->getType(),
			'description'	=> $this->getDescription(),
			'parent'		=> $this->parent ? $this->getParent() : NULL,
		);
	}
}
