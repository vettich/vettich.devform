<?
IncludeModuleLangFile(__FILE__);

if(!function_exists('devdebug')) {
	function devdebug($mess, $filename=null)
	{
		if(is_array($mess)) {
			array_walk_recursive($mess, function(&$mess) {
				$mess = htmlspecialchars($mess);
			});
		}
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
