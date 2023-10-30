<?php
/**
 *	File/Class License Data Class.
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
use CeusMedia\PhpParser\Structure\Traits\HasName;
use Exception;

/**
 *	File/Class License Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class License_
{
	use HasName;

	protected ?string $url		= NULL;

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$name		License name
	 *	@param		?string		$url		License URL
	 *	@return		void
	 */
	public function __construct( string $name, ?string $url = NULL )
	{
		$this->setName( $name );
		if( !is_null( $url ) )
			$this->setUrl( $url );
	}

	/**
	 *	Returns license URL.
	 *	@access		public
	 *	@return		?string
	 */
	public function getUrl(): ?string
	{
		return $this->url;
	}

	/**
	 *	@param		License_		$license
	 *	@return		self
	 *	@throws		MergeException
	 */
	public function merge( License_ $license ): self
	{
		if( $this->name != $license->getName() )
			throw new MergeException( 'Not merge-able' );
		if( NULL !== $license->getUrl() )
			$this->setUrl( $license->getUrl() );
		return $this;
	}

	/**
	 *	Sets license URL.
	 *	@access		public
	 *	@param		?string		$url		License URL
	 *	@return		self
	 */
	public function setUrl( ?string $url ): self
	{
		$this->url	= $url;
		return $this;
	}
}
