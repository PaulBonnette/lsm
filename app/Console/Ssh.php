<?php

namespace App\Console\Commands;

use App\Lsm;
use App\Server;
use App\FileEnv;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class Ssh extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lsm:ssh {server}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = Lsm::abbrev.'Pc ssh into a remote server';

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'server' => fn () => select (
                label: 'Server',
                options: Server::List(),
                default:Lsm::ServerDefault()
            ),
        ];        
    }
                                        // BEFORE missing prompts we can abort
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (! Lsm::IsConfigured()) {
            $this->error('Not configured. run: php artisan lsm:type');
            exit;
        }
        if (! Lsm::IsPc()) {
            $this->error('Server not allowed to ssh to itself');
            exit;
        }
        parent::interact($input, $output);
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        // always remember the last server we worked with
        Lsm::FileEnv()->key(Lsm::SERVER_KEY)->set($this->argument('server'));
        
        $domain = Server::get(Server::SERVER_DOMAIN);
        $user = Server::get(Server::USERNAME);
        echo "ssh $user@$domain".PHP_EOL;
        passthru("ssh $user@$domain");
    }
}
