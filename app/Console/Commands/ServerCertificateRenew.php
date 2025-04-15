<?php

namespace App\Console\Commands;

use App\Lsm;
use App\Server;
use App\Process;
use Illuminate\Console\Command;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use function Laravel\Prompts\confirm;

class ServerCertificateRenew extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lsm:server-certificate-renew {server}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = Lsm::abbrev.'Create a server';

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (! Lsm::IsConfigured()) {
            $this->error('Not configured. run: php artisan lsm:type');
            exit;
        }
        if (! Lsm::IsServer()) {
            $this->error('Server commands must be on the server.  ssh into it.');
            exit;
        }
        parent::interact($input, $output);
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'server' => fn() => select(
                label: 'Server',
                options: Server::List(),
                default: Lsm::ServerDefault()
            ),
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        if (confirm('Certbot renew.  https://cloud.digitalocean.com/networking/firewalls port 80 open on IPV4?')) {
            Process::Command("sudo ufw allow 80")->showCommand()->run();
            Process::Command("sudo ufw status")->showCommand()->run();
            $this->info('This firewall will take affect...');
            if (confirm('Ready to renew?')) {
                Process::Command("sudo ufw reload")->showCommand()->run();
                Process::Command("sudo certbot renew")
                        ->showCommand()->showCommand()->run();
                if (confirm('Have you removed IPV4 on port 80, in your Digital Ocean Firewall?')) { }
                else $this->error('Recommend you close Digital Ocean Firewall port 80');
            } else { 
                $this->info('Closed droplet\'s port 80 firewall');
                $this->error('certificate renewal cancelled');
            }
            Process::Command("sudo ufw deny 80")->showCommand()->run();
            Process::Command("sudo ufw reload")->showCommand()->run();
    } else {
            $this->error('certificate renewal cancelled');
        }             
        

        //$name = $this->validate_cmd(function () {
        //    return $this->ask('Enter simple new server name');
        //}, ['name', 'required']);

        //$email = $this->validate_cmd(function() {
        //    return $this->ask('Enter email');
        //}, ['email','required|email']);

        //$date = $this->validate_cmd(function() {
        //    return $this->ask('Enter date [Eg: 2016-01-01 00:00:00]');
        //}, ['date','required']);
        //if ($this->argument('name')<>'') {
        //    mkdir('./servers/' . $this->argument('name'), 0700);
        //    $this->info('Server '.$this->argument('name').' created');
        //}
        //else
        //    $this->error('Unable to add server');

        //$this->error('missing code');
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
