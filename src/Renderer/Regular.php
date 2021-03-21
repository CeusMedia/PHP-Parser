<?php
/**
 *	...
 *
 *	Copyright (c) 2020 Christian Würker (ceusmedia.de)
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
 *	@copyright		2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
namespace CeusMedia\PhpParser\Renderer;

use CeusMedia\PhpParser\Structure\Class_;

/**
 *	...
 *	@category		Library
 *	@package		CeusMedia_PHP-Parser
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2020 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 */
class Regular
{
	protected $buffer	= [];

	public function __construct()
	{
	}

	public function renderClass( Class_ $class )
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

	protected function renderClassDocBlock( $class ): array
	{
		$lines	= [];
		$lines[]	= '/'.'**';
		if( $class->getDescription() )
			foreach( preg_split( '/\r?\n/', $class->getDescription() ) as $line )
				$lines[]	= $this->renderDocBlockLine( NULL, NULL, $line );
		foreach( $class->getAuthors() as $author ){
			$email	= $author->getEmail() ? '<'.$author->getEmail().'>' : '';
			$name	= $author->getName();
			$value	= $name && $email ? $name.' '.$email : $name.$email;
			$lines[]	= $this->renderDocBlockLine( 'author', $value );
		}


		$lines[]	= ' */';
		return $lines;
//		return join( PHP_EOL, $lines );
	}

	protected function renderDocBlockLine( ?string $property, ?string $value = NULL, ?string $description = NULL ): string
	{
		$parts	= [" *\t"];
		if( $property )
			$parts[]	= '@'.$property.( $value || $description ? "\t\t" : '' );
		if( $value )
			$parts[]	= $value.( $description ? "\t\t" : '' );
		if( $description )
			$parts[]	= $description;
		return join( $parts );
	}

	protected function indentLines( array $lines, $level = 1 ): array
	{
		$indent	= str_repeat( "\t", $level );
		foreach( $lines as $nr => $line )
			$lines[$nr]	= $indent.$line;
		return $lines;
	}

	public function renderClassMethod( $method )
	{
		$lines	= ['/'.'**'];
		if( $method->getDescription() ){
			foreach( explode( PHP_EOL, $method->getDescription() ) as $line )
				$lines[]	= ' *	'.$line;
			$lines[]	= ' *';
		}
		if( $method->getAccess() )
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
		if( $method->getReturn() )
			$lines[]	= ' *	@return		'.$method->getReturn()->getType();
		$lines[] = ' */';

		$lines[] = join( [
			$method->isAbstract() ? 'abstract ' : '',
			$method->getAccess() ? $method->getAccess().' ' : '',
			$method->isStatic() ? 'static ' : '',
			'function '.$method->getName().'(',
			$parameters ? ' '.$parameters.' ' : '',
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
