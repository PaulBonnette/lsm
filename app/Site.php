<?php

namespace App;

class Site 
{
  CONST SITE_NAME='SERVER_NAME';

  public $ServerFile;
  public $SiteFile;
  function __constuctor() {}

  static function EnvFileName(string $site): string {
    // if not set then we try to figure it out for servers with only one location
    // ?  there is only one server when looking at sites!
    return __DIR__.'/../servers/?/sites/'.$site.'/.env_site';
  }

  function CurrentVersion(): int { return 0; }
  function CurrentDir(): string { return '';} 
  function NextVersion(): int { return 0;}
  function NextDir(): string { return ''; } 

  static function setKeyValue(string $site, string $key, string $value) {
    $file =self::EnvFileName($site);
    FileEnv::setKeyValue($file,$key,$value);
  }
  static function getKeyValue(string $site, string $key, string $default='') {
    $file =self::EnvFileName($site);
    return FileEnv::getKeyValue($file,$key,$default);
  }  
}
