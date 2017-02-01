<?
IncludeModuleLangFile(__FILE__);

if(!function_exists('ddebug')) {
	function ddebug($mess, $filename=null)
	{
		if($filename !== null) {
			if(!is_dir($debugPath = __DIR__.'/debug/'))
				mkdir($debugPath, 0775);
			error_log('<pre>'.date('Y/m/d H:i:s')."\n".print_r($mess, true).'</pre>'."\n", 3, $debugPath.$filename.'.html');
		} else {
			echo '<pre>';
			print_r($mess);
			echo '</pre>';
		}
	}
}
