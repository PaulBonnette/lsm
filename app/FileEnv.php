<?php

// no [sections] or you get error: Failed to parse dotenv file. Encountered an invalid name at 

namespace App;                          

use Exception;

class FileEnv
{
  const TYPE_INI = 1;
  const TYPE_SETTINGS = 2;

  private string $filename='';
  private string $key='';
  private string $value='';
  private string $default='';

  function __construct(string $filename)
  {
    $this->filename = $filename;
  }
  static public function file(string $f): FileEnv {
    return new FileEnv($f);
  }
  public function key(string $key): FileEnv {
    $this->key = $key;
    return $this;
  }
  public function value(string $default): FileEnv {
    $this->value = $default;
    return $this;
  }
  public function default(string $default): FileEnv {
    $this->default = $default;
    return $this;
  }
  public function get($key=null): string {
    
    if ($key<>null) $this->key($key);

    $lines = file($this->filename);

    $keyOffset=-1;
    foreach ($lines as $offset=>$line) {
      if (stripos($line,$this->key)!==false)
        $keyOffset=$offset;
    }
    if ($keyOffset==-1) {
      return $this->default;
    }
    else {
      $ary = explode('=',$lines[$keyOffset]);
      //echo print_r($ary,true);
      return trim(str_replace('"','',$ary[1]));
    }
  }
  public function set($value=null): bool {

    if ($value<>null) $this->value($value);

    $lines = file($this->filename);

    $keyOffset=-1;
    foreach ($lines as $offset=>$line) {
      if (stripos($line,$this->key)!==false)
        $keyOffset=$offset;
    }

    if ($keyOffset==-1) {
      array_splice($lines, 0, 0, "$this->key = \"".$this->value."\"".PHP_EOL); 
      $keyOffset=count($lines)+1;   
    }
    else {
      array_splice($lines, $keyOffset, 1, "$this->key = \"".$this->value."\"".PHP_EOL); 
    }
    
    $file_content = implode('', $lines);
    file_put_contents($this->filename, $file_content);
    return true;
}


}
