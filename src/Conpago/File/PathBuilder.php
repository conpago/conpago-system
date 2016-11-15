<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Conpago\File;

	use Conpago\File\Contract\IPathBuilder;

	class PathBuilder implements IPathBuilder
	{
		public function createPath(array $elements)
		{
			return implode(DIRECTORY_SEPARATOR, $elements);
		}

		public function fileName($filePath)
		{
			return basename(str_replace('\\', '/', $filePath));
		}
	}
