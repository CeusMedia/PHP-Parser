# PHP-Parser

![Branch](https://img.shields.io/badge/Branch-0.3.x-blue?style=flat-square)
![Release](https://img.shields.io/badge/Release-0.3.2-blue?style=flat-square)
![PHP version](https://img.shields.io/badge/PHP-%5E7.4_|_%5E8.1-blue?style=flat-square&color=777BB4)
![PHPStan level](https://img.shields.io/badge/PHPStan_level-4-darkgreen?style=flat-square)
[![License](https://img.shields.io/packagist/l/ceus-media/php-parser.svg?style=flat-square)](https://packagist.org/packages/ceus-media/php-parser)
<br/><small>Hint: Use branch 0.4.x for PHP >= 8.1.</small>

PHP parser (and renderer) written in PHP

- collection of Classes for PHP language concepts, like:
	- variables and class members
	- functions and class methods
	- parameters of functions and methods
	- return types of functions and methods
	- accessibility of variables, members and methods
	- abstraction of classes and methods
	- class attributes like final, extends, implements
	- plus a file which holds variables, functions and classes
- a parser to read PHP
	- as string or file into a tree structure
- a renderer to build PHP
	- from a defined or parsed tree structure
