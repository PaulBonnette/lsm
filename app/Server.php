<?php

namespace App;

use Exception;
use App\Helper;
use App\FileEnv;
use Pest\Mutate\Mutators\Visibility\FunctionPublicToProtected;

class Server  
{
  const SERVER_DOMAIN = 'SERVER_DOMAIN';
  const USERNAME = 'USERNAME';
  const FORMAT = [
    'SERVER'=>['SERVER_DOMAIN','SERVER_DESCRIPTION','SERVER_TYPE'],
    'EMAIL'=>['SENDGRID_KEY'],
    'ADMIN'=>['ADMIN_TEXT','ADMIN_EMAIL'],
    'FIREWALL'=>['FIREWALL_WHITELIST'],
    'ACCESS'=>['NON_ROOT'],
    'GITHUB'=>['GIT_USER','GIT_TOKEN','GIT_SOURCE'],
    'WORKSTATION'=>['BACKUP_DB','BACKUP_WWW']
  ];
  public function __construct(private string $alias) {

  }
  static function EnvFileName(string $alias): string {
    return __DIR__.'/../servers/'.$alias.'/.env_server';
  }
  static function File(): string {   // server-set to set server we are working with
    $alias=Lsm::server();
    if ($alias=='')
      throw new Exception('Current server not set. call lsm::server-set');
    return self::EnvFileName($alias);
  }
  static function List(): array
  {
    $folders = Helper::listFolder('./servers');
    return $folders; //array('dev', 'lsi');
  }
  static function Sections(): array {
    return array_keys(self::FORMAT);
  }
  static function Keys(string $section): array         # valid keys in the .env_server file
  {
    return self::FORMAT[$section];
  }
  static function AllKeys(): array         # valid keys in the .env_server file
  { 
    $values=[];
    $sections=self::Sections();
    foreach ($sections as $section)
      foreach (self::FORMAT[$section] as $value)
        $values[]=$value;
    return $values;
  }
                                        // user can ->set() or ->get() from this method since it returns an object
  static function Key(string $key): FileEnv {
    echo self::file();
    echo $key;
    return FileEnv::file(self::file())->key($key);
  }
                                        // for convenience 
  static function Get(string $key): string {
    return FileEnv::file(self::file())->get($key);
  }
    
  //static function setKeyValue(string $key, string $value) {
  //  $file =self::EnvFileName($serverAlias);
  //  FileEnv::setKeyValue($file,$key,$value);
  //}
  //static function getKeyValue(string $key, string $default='') {
  //  $file =self::EnvFileName($serverAlias);
  //  return FileEnv::getKeyValue($file,$key,$default);
  //}

}
