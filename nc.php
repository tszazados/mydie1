<?php


//function exception_handler($exception) {
//  mydie ( "Uncaught exception: " , $exception->getMessage());
//}
//
//set_exception_handler('exception_handler');

/**
 * My helper class for easier debugging
 */
class nc
{
	//additional parameters

	private static $last5lines = "";

	public static function initLogfile()
	{
		$errorLogfile = ini_get("error_log");
		if (file_exists($errorLogfile) && is_readable($errorLogfile)) {
			self::$last5lines = self::execAndCaptureOutputs("tail -25 {$errorLogfile}");
		} else {
			self::$last5lines = "";
		}
	}

	public static function prinErrorLogChanges()
	{
		$errorLogfile = ini_get("error_log");
		if (file_exists($errorLogfile) && is_readable($errorLogfile)) {
			$currentLast5Lines = self::execAndCaptureOutputs("tail -25 {$errorLogfile}");
		} else {
			$currentLast5Lines = "";
		}
		if ($currentLast5Lines !== self::$last5lines) {
			$currentLast5Lines = str_replace("\n", "<br>", $currentLast5Lines);
			$currentLast5Lines = str_replace("\r", "", $currentLast5Lines);
			self::$last5lines = str_replace("\n", "<br>", self::$last5lines);
			self::$last5lines = str_replace("\r", "", self::$last5lines);

//			$currentLast5Lines = str_replace ( self::$last5lines, self::$last5lines . "eue5xdtzxzuusdrewrewe" , $currentLast5Lines. "douw7xdzuweondjzs32" ) ;

//			$currentLast5Lines = str_replace ("eue5xdtzxzuusdrewrewe","<span style='color:yellow'>",$currentLast5Lines);
//			$currentLast5Lines = str_replace ("douw7xdzuweondjzs32","</span>",$currentLast5Lines);

			print ("<div style='background-color:#000000;font-size:14px;letter-spacing: -2px;color:white;'>");

			print $currentLast5Lines;
			print ("</div style='background-color:#000000'>");
			error_log("");
		}
	}



	private static function getInsertSpacer($spacerHeight)
	{
		return "<div class=ip style='height:{$spacerHeight}px'></div>";
	}

	public static function mydie()
	{
		static $mydie_call_num = 0;
		$mydie_call_num++;
		if ($mydie_call_num > 1) {
			die (strtoupper(__METHOD__) . ": recursion detected, aborting.");
		}
		print <<<EOF
			<body style='background-color:#707070'>
			<style>
			div
			{
			  border: 1px solid rgba(255,255,255,0.5);
			  box-shadow: 5px 5px 8px rgba(0,0,0,.5);
			 }
			.ip
			{
			  border: 0px !important;
			  box-shadow: none !important;
			 
			}
			</style>
EOF;
		self:: mydielike(func_get_args());

		self::prinErrorLogChanges();

		print "</body>";
		die();
	}

	private static function rand_color()
	{
		static $callCount = -2;

		$callCount++;
		$alpha = "0.6";

		$adder = "background: repeating-linear-gradient(45deg,#606dbc,#606dbc 10px,#465298 10px,#465298 20px);";


		if ($callCount === 0) {
			return ("rgba(255,0,0,{$alpha})");
		} elseif ($callCount === 1) {
			return ("rgba(0,255,0,{$alpha});");
		} elseif ($callCount === 2) {
			return ("rgba(255,255,0,{$alpha})");
		} elseif ($callCount === 3) {
			return ("rgba(0,255,255,{$alpha})");
		} elseif ($callCount === 4) {
			return ("rgba(255,0,255,{$alpha})");
		} elseif ($callCount === 5) {
			return ("rgba(255,255,255,{$alpha})");
		} elseif ($callCount === 6) {
		}


		$a1 = mt_rand(0, 255);
		$a2 = mt_rand(0, 255);
		$a3 = mt_rand(0, 255);
		return ("rgba($a1,$a2,$a3,0.5)");
	}

	private static function mydielike()
	{
		$colors = [];
		function lc_rdln($filename, $X, $radius = 0)
		{
			$i = 0;
			$from = $X - $radius < 0 ? 0 : $X - $radius;
			$to = $X + $radius;
			$retlines = "";
			if (($handle = fopen($filename, "r"))) {
				while (($line = fgets($handle)) !== false) {
					$i++;
					if ($i >= $from && $i <= $to) {
						$i !== $X ? $retlines .= trim($line) . "<br>" : $retlines .= "<b style='color:black;background-color:darkcyan'>" . trim($line) . "</b>" . "<br>";
						if ($i === $to) {
							fclose($handle);
//							$retlines = str_replace (" "," ", $retlines);
							return "<span style='color:white'></span><br>" . $retlines . "<span style='color:white'></span><br>";
						}
					}
				}
				fclose($handle);
//				$retlines = str_replace (" "," ", $retlines);
				return "<br>" . $retlines . "<br>";
			}
			return "???";
		}

		$dbgBackTrace = debug_backtrace();
//		$i = 0;
//		$new = [];
//		foreach ($dbgBackTrace as $key => $value) {
//			if ($i != 3) {
//				$new [$key] = $value;
//			}
//			$i++;
//		}

//		$dbgBackTrace = $new;
		//$dbgBackTrace =$dbgBackTrace;

		//unset($dbgBackTrace[0]);

		if (($syspor = +function_exists("syslog_") & +class_exists("k_portal")) === true) {
			syslog_("MYDIE called.");
		}

		for ($maxpad = $maxlev = $breakme = 0, $i = 1; ($i < 1000 && $breakme === 0); $i++, $maxlev++) {
			$maxpad += isset ($dbgBackTrace[$i]) === true ? 1 : 0 + $breakme++;
		}
		for ($breakme = 0, $dbglevels = array(), $i = 1; ($i < 1000 && $breakme === 0); $i++) {
			$padder = ($maxpad - $i) * 20;
			$padderp = 15;
			$lineNumber = $dbgBackTrace[$i]['line'];
			for ($lines = "", $k = 0; $k < 9; $k++) {
				$top = $k * 18;
				$lines .= "<span style='opacity:0.7;color:cyan;position:absolute;left:{$padderp}px;top:{$top}px;'>" . ($lineNumber + $k - 6) . ":</span>";
			}

			$tocol = ($i === 2) ? "76359D" : "0060ff";

			$dirname = pathinfo($dbgBackTrace[$i]['file'])["dirname"];

			$dirname = str_ireplace("C:\\XAMPP\\HTDOCS\\", "./", $dirname);
			$dirname = str_ireplace("\\", "/", $dirname);

			$fileName = $dbgBackTrace[$i]['file'];
			$fileName2 = pathinfo($dbgBackTrace[$i]['file'])["filename"];

			if (array_key_exists($dirname . $fileName, $colors) === false) {
				$colors [$dirname . $fileName] = self::rand_color();
			}
			$thisColor = $colors[$dirname . $fileName];

			$padderpp = $padder + $padderp;


			$directoryAdder = "<span style='color:rgba(255,255,255,0.5)'> in </span><span style='color:rgba(255,0,255,1);letter-spacing:-1px !important;'>{$dirname}/<span style='color:#ffc0ff'>{$fileName2}.php</span></span>";

			$functionName = $dbgBackTrace[$i]['function'];
			$filenameData = pathinfo($dbgBackTrace[$i]['file'])["filename"];
			$fileLcRndl = @lc_rdln($dbgBackTrace[$i]['file'], $lineNumber, 3);
			$FILE__ = __FILE__;
			$LINE__ = __LINE__;
			$dbglevels[] = isset ($dbgBackTrace[$i]) === true ? "<div style='border-left:{$padder}px solid #404040;position:relative;background-color:black;color:white;font-family:courier;font-size:16px'> yyy.){$functionName} # {$lineNumber} # <span style='color:yellow' >{$filenameData}.php{$directoryAdder}" . "</span></div><div style='border-left:{$padderpp}px solid {$thisColor};font-weight:normal;background:linear-gradient(to right, #0000ff 0%,#$tocol 100%); ;color:#ffff00;font-family:courier;padding-left:100px;font-size:16px;position:relative;'>{$fileLcRndl}{$lines}</div>" : "  <{$FILE__}php#{$LINE__}__" . ($breakme++) . ">";
		}
		$style_div = "padding:5px;font-weight:normal;border:0px solid black !important;background-color: transparent !important;font-family:\"courier\" !important;color:white;font-size:14px !important;";
		print "<div style='COLOR:BLACK !IMPORTANT;$style_div' >";

//		unset($dbglevels[count($dbglevels)-1]);
//		unset($dbglevels[0]);

		$str = implode(self::getInsertSpacer(9), str_replace("_once", "", array_reverse($dbglevels)));

		$maxDB = substr_count($str, "yyy.");

		$ppCount = 0;
		for ($j = 0, $jp1 = 1; $j < $i + 1; $j++, $jp1++, $ppCount++) {
			//$str = str:: reotf ( "yyy.)" , "{$jp1}.)  " , $str );
			if (strpos($str, "yyy.") !== false) {
//				if ($ppCount !== $maxDB - 1)
				{
					$str = explode("yyy.)", $str);
					$str[0] .= "{$jp1}.)  ";
					$str = implode("yyy.)", $str);
					$str = str_replace("{$jp1}.)  yyy.)", "{$jp1}.)  ", $str);
				}
//				else break;
			}
		}
		$str = self:: reotf("=>", "", $str);
		if (strpos($str, "=>") !== false) {
			$str = explode("=>", $str);
			$rnd = mt_rand(1, 30000);
			$str[0] .= $rnd;
			$str = implode("=>", $str);
			$str = str_replace("=>" . $rnd, "", $str);
		}
		print $str . "<br>";
		mt_srand(303);
		for ($i = 0, $breakme = false, $tmpcnt = func_num_args(); ($i < $tmpcnt && $breakme === false); $i++) {
			$data1 = func_get_args()[$i];
			$r = mt_rand(0, 100);
			$g = mt_rand(0, 100);
			$b = mt_rand(0, 100);
			$randomcolor = "rgb( $r,$g,$b )";
			print "<div style='COLOR:WHITE !IMPORTANT;{$style_div};background-color: $randomcolor !important;' \">\n\n";
			print ("<pre style='font-family:courier;font-size:16px'>" . str_replace(" => <br>\n", " => ", htmlspecialchars(var_export($data1, true))) . "</pre>");
			print "\n\n</div>";
			error_log("MYDIE called" );
			$data1Exported = var_export ($data1, true);
			if ($data1Exported!==null && is_string($data1Exported) && strlen($data1Exported) > 0) {
				$data1Exported = str_replace ("\r","",$data1Exported);
				$data1Exported = explode ("\n", $data1Exported);

				foreach ($data1Exported as $string)
				{
					error_log($string );
				}

			}

		}
	}

	public static function reotf($search, $replace, $string, $limit = 1)
	{
		$search_len = strlen($search);
		for ($i = 0; $i < $limit; $i++) {
			if (($pos = (strpos($string, $search))) === false) {
				break;
			}
			$string = substr_replace($string, $replace, $pos, $search_len);
		}

		return $string;
	}

	public static function execAndCaptureOutputs($command)
	{
		$command = str_replace(" 2>&1", "", $command);

		return `$command 2>&1`;
	}


}

function mydie()
{
//	$oldFuncGetArg = func_get_args() ;
//	$newFuncGetArgs = [] ;
//	$funcGetArgCount = count($oldFuncGetArg) ;
//	$counter=0 ;
//
//	foreach ($oldFuncGetArg as $currentFuncGetArgKey => $currentFuncGetArgValue) {
//		if ($counter !== $funcGetArgCount-1) {
//			$newFuncGetArgs[$currentFuncGetArgKey]=$currentFuncGetArgValue;
//		}
//		$counter ++ ;
//	}
//
//	nc::mydie($newFuncGetArgs);
	nc::mydie(func_get_args());
}

nc::initLogfile();

