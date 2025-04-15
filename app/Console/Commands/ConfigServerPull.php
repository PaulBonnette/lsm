<?php

namespace App\Console\Commands;

use App\Lsm;
use App\Server;
use App\FileEnv;
use App\Process;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;
use function Laravel\Prompts\confirm;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class ConfigServerPull extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lsm:config-server-pull {server}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = Lsm::abbrev . 'Pc pulls a remote server\'s configuration';

    // BEFORE missing prompts we can abort
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (! Lsm::IsConfigured()) {
            $this->error('Not configured. run: php artisan lsm:type');
            exit;
        }
        if (! Lsm::IsPc()) {
            $this->error('Server not allowed to pull project');
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
                                        // remember selected server for next time
        Lsm::FileEnv()->key(Lsm::SERVER_KEY)->set($this->argument('server')); 

        $domain_alias=Lsm::FileEnv()->key(Lsm::SERVER_KEY)->get();
        $domain = Server::get(Server::SERVER_DOMAIN);
        $user = Server::get(Server::USERNAME);
        $PROJECT_DIRECTORY = Lsm::PROJECT_DIR;
        // servers dir must already exist or we could not have connected to run this 
        Process::Command("rsync -av \"$user@$domain:~/$PROJECT_DIRECTORY/servers/$domain_alias/\" \"./servers/$domain_alias/\" ")
            ->showCommand()->showOutput()->run();
        echo "Use github to update project later" . PHP_EOL;
    }
}
