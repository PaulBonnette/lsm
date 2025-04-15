<?php

namespace App\Console\Commands;

use App\Lsm;
use App\Server;
use Illuminate\Console\Command;
use function Laravel\Prompts\search;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use function Laravel\Prompts\select;

class ServerCertificateScan extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lsm:server-certificate-scan server {server}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = Lsm::abbrev.'Create a server';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        //$name = $this->validate_cmd(function () {
        //    return $this->ask('Enter simple new server name');
        //}, ['name', 'required']);

        //$email = $this->validate_cmd(function() {
        //    return $this->ask('Enter email');
        //}, ['email','required|email']);

        //$date = $this->validate_cmd(function() {
        //    return $this->ask('Enter date [Eg: 2016-01-01 00:00:00]');
        //}, ['date','required']);
        
        $this->error('code missing');
    }

    /**
     * Validate an input.
     *
     * @param  mixed   $method
     * @param  array   $rules
     * @return string
     */
    public function validate_cmd($method, $rules)
    {
        $value = $method();
        $validate = $this->validateInput($rules, $value);

        if ($validate !== true) {
            $this->warn($validate);
            $value = $this->validate_cmd($method, $rules);
        }
        return $value;
    }

    public function validateInput($rules, $value)
    {

        $validator = Validator::make([$rules[0] => $value], [$rules[0] => $rules[1]]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return $error->first($rules[0]);
        } else {
            return true;
        }
    }
}
