<?php


namespace App;

class Helper
{
    public $promptValues = [];
    static function projectRoot(): string
    {
        return substr(__DIR__, 0, -4);    // remove /src and we have project directory
    }
    static function currentDirectory(): string
    {
        return getcwd();    // remove /src and we have project directory
    }
    static function currentDirectoryBase(): string
    {
        return basename(getcwd());
    }

    function Prompt(string $caption, $index = '')
    {
        echo $caption;
        $fin = fopen("php://stdin", "r");
        $line = fgets($fin);
        if ($index <> '')
            $this->promptValues[$index] = $line;  // remember this value
        return $line;
    }

    static function PromptConfirm(string $caption):bool
    {
        echo $caption.' (y/N)';
        $fin = fopen("php://stdin", "r");
        $line = fgets($fin);
        $line = ' '.$line;
        return (strpos($line,'y') or strpos($line,'Y'));
    }
    
    static function RemoveSpecialChar(string $str): string
    {
        return str_replace(array(
            '\'',
            '"',
            ',',
            ';',
            '<',
            '>'
        ), ' ', $str);
    }
    //static function left($str, $length) {
    //    return substr($str, 0, $length);
    //}
    //static function right($str, $length) {
    //    return substr($str, -$length);
    //}
    static function listFolder($dir) {
        if (!is_dir($dir)) 
            return [];
        $result = array();
        $ffs = scandir($dir);
        foreach($ffs as $ff){
           if($ff != '.' && $ff != '..') {
               $info = $ff; //array("name" => $ff, "pathTo" => $dir.'/'.$ff);
               //echo realpath($dir.'/'.$ff).PHP_EOL;
               if(! is_file($dir.'/'.$ff)) {  
               //    $info['children'] = self::listFolder($dir.'/'.$ff);  
               $result[] = $ff; //array("name" => $ff, "pathTo" => $dir.'/'.$ff);
               }
               
           }    
        }
        return $result;
     }


    static function Passed(string $out='') {
        echo "\033[0;32mPASSED\033[0m".' '.$out.PHP_EOL;
    }
    static function Good(string $out='') {
        echo "\033[0;32mPASSED\033[0m".' '.$out.PHP_EOL;
    }
    static function Completed(string $out='') {
        echo "\033[0;32mCOMPLETED\033[0m".' '.$out.' '.PHP_EOL;
    }
    static function Failed(string $out='') {
        echo "\033[0;33mFAILED\033[0m".' '.$out.' '.PHP_EOL;
    }
    static function Cancelled(string $out='') {
        echo "\033[0;33mCANCELLED\033[0m".' '.$out.' '.PHP_EOL;
    }
    static function Note(string $out='') {
        echo "\033[0;34mNOTE\033[0m".' '.$out.' '.PHP_EOL;
    }
    static function Fixed(string $out='') {
        echo "\033[0;36mNOTE\033[0m".' '.$out.' '.PHP_EOL;
    }
    static function Out(string $caption, string $out='') {
        echo "\033[0;34m$caption\033[0m".' '.$out.' '.PHP_EOL;
    }
    
}
