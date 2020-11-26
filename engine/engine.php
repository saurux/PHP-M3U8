<?php

/**
 * @author: SAURUX ~ https://zeroware.ru
 * @version: v0.1
 */

class Master
{
	private static $quality = [];
	private static $files   = [];
	private static $path	= '';

	static public function Setup(string $url = '')
	{
		self::$path = trim($url);
	}

	static public function PrintDebug()
	{
		echo "Resolutions:";
		echo '<pre>'. print_r(self::$quality, 1) .'</pre>';
		echo "Files:";
		echo '<pre>'. print_r(self::$files,   1) .'</pre>';
	}

	static public function GetVariable($start, $end, $object, $i = 1)
	{
		$part  = explode($start, $object);
		$start = $part[$i++];
		$final = explode($end,  $part[$i]);
		return   $final[0];
	}

	static public function GetResolution(string $query = '')
	{
		$query     = trim($query);
		$master    = $query == '' ? self::$path . 'master.m3u8' : self::$path . 'master.m3u8' . $query;
		$object    = file_get_contents($master);
		$resolution= substr_count($object, 'RESOLUTION');

		for($i = 0; $i <= $resolution; $i++)
		{
			$variable = trim(self::GetVariable('RESOLUTION=', ',', $object, $i));
			if(!in_array($variable, self::$quality) && $variable != '')
			{
				array_push(self::$quality, $variable);
			}
		}

		return true;
	}

	static public function GetFiles(string $query = '')
	{
		$query     = trim($query);
		$master    = $query == '' ? self::$path . 'master.m3u8' : self::$path . 'master.m3u8' . $query;
		$object    = file_get_contents($master);
		$videos    = substr_count($object, 'AUDIO="audio0"');

		for($i = 0; $i <= $videos; $i++)
		{
			$variable = trim(self::GetVariable('AUDIO="audio0"', '#EXT', $object, $i));
			if(!in_array($variable, self::$files) && $variable != '')
			{
				array_push(self::$files, $variable);
			}
		}
		
		return true;
	}

	static public function Start(string $object, string $query = '')
	{
		$file      = strstr($object, 'http') ? $object : self::$path . $object;
		$element   = file_get_contents($file);
		$count     = substr_count($element, '.ts');
		$files     = [];

		for($i = 0; $i <= $count; $i++)
        {
            $url      = trim(self::GetVariable('0,', '#EXT', $element, $i));
            $url      = strstr($url, 'http') ? $url : self::$path . $url;
            if(!in_array($url, $files) && $url != '')
            {
                if($i == $count) $content .= basename($url, trim($query)); 
                if($i != $count) $content .= basename($url, trim($query)) . "+";
                array_push($files, $url);
                $filename = basename($url, trim($query));
                file_put_contents($filename, file_get_contents($url));
            }   
        }

        return true;
	}

	static public function Get(string $type = '')
	{
		switch ($type) {
			case 'files':
			return self::$files;
			break;
			
			case 'resolutions':
			return self::$quality;
			break;
		}

		return NULL;
	}
}

?>