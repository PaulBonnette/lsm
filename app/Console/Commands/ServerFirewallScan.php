<?php

namespace App\Console\Commands;

use App\Lsm;
use App\Helper;
use App\Server;
use App\FileEnv;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\confirm;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class ServerFirewallScan extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lsm:server-firewall-scan {server} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = Lsm::abbrev.'Edit a server\'s configuration';

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
        $output=[];
        $result=0;
        exec('sudo ufw status', $output, $result);
        foreach ($output as $line) {
            $this->info($line);
        }
        
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
