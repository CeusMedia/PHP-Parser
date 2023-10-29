<?php
/**
 *	...
 *
 *	Copyright (c) 2020-2023 Christian Würker (ceusmedia.de)
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
 *	@package		CeusMedia_PHP-Parser
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Renderer;

use CeusMedia\PhpParser\Structure\Class_;
use CeusMedia\PhpParser\Structure\Method_;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Regular
{
	protected array $buffer	= [];

	public function __construct()
	{
	}

	public function renderClass( Class_ $class ): string
	{
		$classContent	= [];

		foreach( $class->getMembers() as $member ){
			$classContent[]	= $member->getAccess().' '.$member->getName().';';
			$classContent[]	= '';
		}

		foreach( $class->getMethods() as $method )
			foreach( $this->renderClassMethod( $method ) as $line )
				$classContent[]	= $line;

		$classContent	= join( PHP_EOL, $this->indentLines( $classContent ) );

		$this->buffer	= [];
		foreach( $this->renderClassDocBlock( $class ) as $line )
			$this->buffer[]	= $line;
		$classSignatur	= 'class '.$class->getName();
		if( $class->isAbstract() )
			$classSignatur	= 'abstract '.$classSignatur;
		else if( $class->isFinal() )
			$classSignatur	= 'final '.$classSignatur;
		$this->buffer[]	= $classSignatur;
//		print_r( $class );
		$this->buffer[]	= '{';
		$this->buffer[]	= $classContent;
		$this->buffer[]	= '}';
		return implode( PHP_EOL, $this->buffer ).PHP_EOL;
	}

	/**
	 *	@param		Class_		$class
	 *	@return		array<string>
	 */
	protected function renderClassDocBlock( Class_ $class ): array
	{
		$lines		= [];
		$lines[]	= '/'.'**';
		if( NULL !== $class->getDescription() ){
			$parts	= preg_split( '/\r?\n/', $class->getDescription() ) ?: [];
			foreach( $parts as $line )
				$lines[]	= $this->renderDocBlockLine( NULL, NULL, $line );
		}
		foreach( $class->getAuthors() as $author ){
			$email		= ( '' !== ( $author->getEmail() ?? '' ) ) ? '<'.$author->getEmail().'>' : '';
			$name		= $author->getName();
			$value		= NULL !== $name && $email ? $name.' '.$email : $name.$email;
			$lines[]	= $this->renderDocBlockLine( 'author', $value );
		}


		$lines[]	= ' */';
		return $lines;
//		return join( PHP_EOL, $lines );
	}

	/**
	 *	@param		string|NULL		$property
	 *	@param		string|NULL		$value
	 *	@param		string|NULL		$description
	 *	@return		string
	 */
	protected function renderDocBlockLine( ?string $property, ?string $value = NULL, ?string $description = NULL ): string
	{
		$parts	= [" *\t"];
		if( NULL !== $property )
			$parts[]	= '@'.$property.( NULL !== $value || NULL !== $description ? "\t\t" : '' );
		if( NULL !== $value )
			$parts[]	= $value.( NULL !== $description ? "\t\t" : '' );
		if( NULL !== $description )
			$parts[]	= $description;
		return join( $parts );
	}

	/**
	 *	@param		array<string>	$lines		Original lines
	 *	@param		int				$level		Indent level
	 *	@return		array<string>				Indented lines
	 */
	protected function indentLines( array $lines, int $level = 1 ): array
	{
		$indent	= str_repeat( "\t", $level );
		foreach( $lines as $nr => $line )
			$lines[$nr]	= $indent.$line;
		return $lines;
	}

	/**
	 *	@param		Method_		$method
	 *	@return		array<string>
	 */
	public function renderClassMethod( Method_ $method ): array
	{
		$lines	= ['/'.'**'];
		if( NULL !== $method->getDescription() ){
			foreach( explode( PHP_EOL, $method->getDescription() ) as $line )
				$lines[]	= ' *	'.$line;
			$lines[]	= ' *';
		}
		if( NULL !== $method->getAccess() )
			$lines[]	= ' *	@abstract';
		if( $method->isStatic() )
			$lines[]	= ' *	@static';
		foreach( $method->getParameters() as $parameter ){
			$line	= ' *	@param		'.$parameter->getType();
			if( $parameter->getDescription() )
				$line	.= '		'.$parameter->getDescription();
			$lines[]	= $line;
		}
		foreach( $method->getThrows() as $throws ){
			$line	= ' *	@throws		'.$throws->getName();
			if( $throws->getReason() )
				$line	.= '		'.$throws->getReason();
			$lines[]	= $line;
		}
		if( NULL !== $method->getReturn() ){
			$return		= $method->getReturn();
			$desc		= $return->getDescription() ? '		'.$return->getDescription() : '';
			$lines[]	= ' *	@return		'.$return->getType().$desc;
		}
		$lines[] = ' */';

		$lines[] = join( [
			$method->isAbstract() ? 'abstract ' : '',
			NULL !== $method->getAccess() ? $method->getAccess().' ' : '',
			$method->isStatic() ? 'static ' : '',
			'function '.$method->getName().'(',
//			$parameters ? ' '.$parameters.' ' : '',
			')',
			$method->getReturn() ? ': '.$method->getReturn()->getType() : '',
		] );
		$lines[]	= '{';
		$lines[]	= join( $this->indentLines( $method->getSourceCode() ) );
		$lines[]	= '}';
		$lines[]	= '';
		return $lines;
	}
}
