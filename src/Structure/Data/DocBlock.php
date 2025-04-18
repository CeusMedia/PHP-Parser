<?php
declare(strict_types=1);

/**
 *	File/Class/Function/Method Author Data Class.
 *
 *	Copyright (c) 2025 Christian Würker (ceusmedia.de)
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
 *	@copyright		2025 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Structure\Data;

use CeusMedia\PhpParser\Exception\MergeException;
use CeusMedia\PhpParser\Structure\Author_;
use CeusMedia\PhpParser\Structure\License_;
use CeusMedia\PhpParser\Structure\Parameter_;
use CeusMedia\PhpParser\Structure\Return_;
use CeusMedia\PhpParser\Structure\Throws_;
use CeusMedia\PhpParser\Structure\Traits\HasName;
use CeusMedia\PhpParser\Structure\Trigger_;

/**
 *	File/Class/Function/Method Author Data Class.
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2025 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class DocBlock
{
	//  --  NAMES LISTS OF OBJECTS  --  //

	/** @var array<string,Parameter_> $param */
	public array $param			= [];

	/** @var array<int,Throws_> $throws */
	public array $throws		= [];

	/** @var array<int,Author_> $authors */
	public array $author		= [];

	/** @var array<int,License_> $license */
	public array $license		= [];

	/** @var array<int,Trigger_> $trigger */
	public array $trigger		= [];


	//  --  LISTS OF STRINGS  --  //

	/** @var array<int,string> $implements */
	public array $implements	= [];

	/** @var array<int,string> $deprecated */
	public array $deprecated	= [];

	/** @var array<int,string> $todo */
	public array $todo			= [];

	/** @var array<int,string> $copyright */
	public array $copyright		= [];

	/** @var array<int,string> $see */
	public array $see			= [];

	/** @var array<int,string> $uses */
	public array $uses			= [];

	/** @var array<int,string> $link */
	public array $link			= [];


	//  --  STRINGS  --  //

	public ?Return_ $return	 	= NULL;

	public string $since		= '';
	public string $version		= '';
	public string $access		= '';
	public string $category		= '';
	public string $package		= '';
	public string $subpackage	= '';
	public string $description	= '';
}