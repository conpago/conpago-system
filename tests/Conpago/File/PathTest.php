<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-10
	 * Time: 07:57
	 */

	namespace Conpago\File;


	use Conpago\File\Path;

	class PathTest extends \PHPUnit_Framework_TestCase
	{
		function testGetRealPath()
		{
			$path = new Path("a", "");
			$this->assertEquals('a', $path->get());
		}

		function testGetPath()
		{
			$path = new Path("", "a/b/c");
			$this->assertEquals('a/b/c', $path->getReal());
		}
	}
