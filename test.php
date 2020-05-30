<?php
function myscandir($dir)
{
	$list = scandir($dir);
	unset($list[0],$list[1]);
	return array_values($list);
}
function clear_dir($dir)
{
	$list = myscandir($dir);
	foreach ($list as $file)
	{
		unlink($dir.$file);
	}
}
clear_dir('./avatars/');