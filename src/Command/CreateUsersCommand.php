
<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Authentication\AuthenticationService;
use Cake\Http\ServerRequest;

class CreateUsersCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $service = new AuthenticationService();

        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ],
        ]);

        $io->out('Authentication identifier loaded successfully.');

        return static::CODE_SUCCESS;
    }
}
