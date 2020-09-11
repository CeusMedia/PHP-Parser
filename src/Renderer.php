<?php
namespace CeusMedia\PhpParser;

use CeusMedia\PhpParser\Structure\Class_;

class Renderer
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
		}
		$classContent	= join( PHP_EOL, $this->indentLines( $classContent ) );

		$this->buffer	= [];
		foreach( $this->renderClassDocBlock( $class ) as $line )
			$this->buffer[]	= $line;
		$classSignatur	= 'class '.$class->getName();
		if( $class->isAbstract() )
			$classSignatur	= 'abstract '.$classSignatur;
		else if( $class->isFinal )
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
		$lines[]	= '/**';
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
		return join( PHP_EOL, $lines );
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
}
