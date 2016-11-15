<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-10
	 * Time: 07:57
	 */

	namespace Conpago\File;


	class PathBuilderTest extends \PHPUnit_Framework_TestCase
	{
		function testCreatePath()
		{
			$path = new PathBuilder();
			$this->assertEquals('a'.DIRECTORY_SEPARATOR.'b', $path->createPath(['a', 'b']));
		}

		function testFileNameWithSlash()
		{
			$path = new PathBuilder();
			$this->assertEquals('a.txt', $path->fileName('b/a.txt'));
		}

		function testFileNameWithBackslash()
		{
			$path = new PathBuilder();
			$this->assertEquals('a.txt', $path->fileName('b\a.txt'));
		}
	}
