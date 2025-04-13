<?php

namespace App\Console\Commands;

use App\Lsm;
use App\Helper;
use App\Server;
use Illuminate\Console\Command;
use function Laravel\Prompts\search;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class ConfigAdd extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lsm:config-add {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = Lsm::abbrev.'Add a server to lsm\'s configuration';

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        //must be able to add on PC or you could not connect to push project!
        //$servers=Server::List();
        //if (Lsm::IsPc()) {
        //    $this->error('Server command not allowed on PC');
        //    exit;
        //}
        if (Lsm::IsServer() and !empty($servers)) {
            $this->error('Server already defined for this server');
            exit;
        }
        parent::interact($input, $output);
    }

    protected function promptForMissingArgumentsUsing(): array

    {
        return [
            'name' => 'New server (short. no special characters)'
            /*
            'name' => fn () => search (
                label: 'New server alias:',
                placeholder: 'E.g. "dev"',
                options: fn ($value) => strlen($value) > 0
                    ? Server::List()
                    : []
            
            ),
            */
        ];        
    }
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
        if ($this->argument('name')<>'') {
            if (!is_dir('./servers')) mkdir('./servers/', 0700);
            mkdir('./servers/' . $this->argument('name'), 0700);
            copy('./links/templates/.env_server','./servers/'.$this->argument('name').'/.env_server');
            $this->info('Server '.$this->argument('name').' created');
        }
        else
            $this->error('Server name missing');
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
