<?php

namespace App;

class Lsm                               // Laravel Server Manager
{
    const TYPE_KEY = 'LSM_TYPE';
    const TYPE_PC_VALUE = 'PC';
    const TYPE_SERVER_VALUE = 'SERVER';

    const SERVER_KEY = 'LSM_SERVER';// current server we are working with

    const abbrev = '';//LSM - ';
    const dir = 'manager';              // ~/manager is where project lives

    const PROJECT_DIR = 'lsm';

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    static function ProjectPath () {
        return str_replace('/app','',app_path());
    }
    static function Env() {             // main project .env track default server, etc.
        return '.env';
    }
    static function Type () {
        return FileEnv::file(self::Env())->get(self::TYPE_KEY);
    }
    static function Server () {
        return FileEnv::file(self::Env())->get(self::SERVER_KEY);
    }
    static function IsConfigured () {
        return (self::Type()==self::TYPE_PC_VALUE or self::Type()==self::TYPE_SERVER_VALUE);
    }
    static function IsPc () {
        return (self::Type()==self::TYPE_PC_VALUE);
    }
    static function IsServer () {
        return (self::Type()==self::TYPE_SERVER_VALUE);
    }
}
