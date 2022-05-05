<?php
/**
 * 
 * Title: Config File Parser
 * Purpose: Parse text based files and extract specific data
 * 
 * Version: 1.0
 * Publish Date: 04-01-2022
 * 
 * Author: Ryan Huff
 * Email: configfileparser@ryanthomashuff.com
 * 
 */

class ConfigParser_v1 {

    var $ConfigDir = "config_files"; //FOLDER WITH INPUT CONFIG FILES
    var $ConfigFileExt = '.yml'; //FILE EXTENSION OF THE CONFIG FILES    
    var $sitelist = array(); //INIT CONSTRUCT ARRAY    
    var $finalCSV = "Site Name,Circuit Designation,Configured Upload Speed,Configured Download Speed\r\n"; //HEADER COLUMN NAMES FOR OUTPUT CSV FILE
    var $OutputFilename = "ParsedOutput_"; //NAME OF OUTPUT CSV FILE
    
    public function __construct() {
        //ITERATION IS DONE FOR EACH FILE IN THE "$ConfigDir" FOLDER (EXCEPT '.' AND '..') AND A KEY=>VALUE PAIR ARRAY IS CREATED.
	$ConfigFiles = array_diff(scandir($this->ConfigDir), array('.', '..'));
        foreach ($ConfigFiles as $item) {
            $this->sitelist[$item] = rtrim($item, $this->ConfigFileExt);
        }
    }
    
    function getBetween($string, $start = "", $end = ""){
	//PARSER LOGIC THAT RETURNS THE SUBSTRING VALUE BETWEEN TWO OTHER VALUES IN THE PARENT STRING
        if (strpos($string, $start)) {
            $startCharCount = strpos($string, $start) + strlen($start);
            $firstSubStr = substr($string, $startCharCount, strlen($string));
            $endCharCount = strpos($firstSubStr, $end);
            if ($endCharCount == 0) {
                $endCharCount = strlen($firstSubStr);
            }
            return substr($firstSubStr, 0, $endCharCount);
        }
    }
}

$cp = new ConfigParser_v1();

/*
 * SET TEXT LIMITERS
 * USAGE: SET UNIQUE START AND STOP LIMITERS TO USE IN THE CONFIG FILE ITERATOR
 */

$PriStart = "<REPLACE THIS WITH THE BEGINNING LIMITER FOR THE FIRST SET>";
$SecStart = "<REPLACE THIS WITH THE BEGINNING LIMITER FOR THE SECOND SET>";
$Stop = "<REPLACE THIS WITH THE ENDING LIMITER>";

/*
 * CONFIG FILE ITERATOR
 * USAGE: THE LOGIC USED IN THE CONFIG FILE ITERATOR IS CUSTOMIZED LOGIC TAILORED TO THE USE OF THE INSTANTIATION
 */

foreach ($cp->sitelist as $SF => $SN) {
    $ConfigContent = file_get_contents($cp->ConfigDir . "/$SF");
    
    //FIRST TEXT OBJECT TO PARSE
    $prime = trim($cp->getBetween($ConfigContent, $PriStart, $Stop));
    $primes = explode(" ", $prime);
    $FinalPrime = trim($primes[0]) . " " . trim($primes[1]) . "," . trim($primes[9]) . " " . trim($primes[10]);
    
    //ADD FIRST TEXT OBJECT TO FINAL OUTPUT
    $cp->finalCSV .= "$SN,[FD_PRI_INT],$FinalPrime\r\n";
    
    //SECOND TEXT OBJECT TO PARSE
    $seco = trim($cp->getBetween($ConfigContent, $SecStart, $Stop));
    $secos = explode(" ", $seco);
    $FinalSeco = trim($secos[0]) . " " . trim($secos[1]) . "," . trim($secos[9]) . " " . trim($secos[10]);
    
    //ADD SECOND TEXT OBJECT TO FINAL OUTPUT
    if (!empty($secos[10])) {
        $cp->finalCSV .= "$SN,[FD_SEC_INT],$FinalSeco\r\n";
    }

}
$filedate = new Datetime("now");
fwrite(fopen($cp->OutputFilename . $filedate->format('U') . ".csv","w"), $cp->finalCSV);
?>

