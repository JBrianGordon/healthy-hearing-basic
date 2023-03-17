<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * PopulateLocationUsers command.
 */
class PopulateLocationUsersCommand extends Command
{
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out('Populating locations_users data...');

        $locationUsersTable = $this->fetchTable('LocationUsers');
        $locationsUsersTable = $this->fetchTable('LocationsUsers');
        $usersTable = $this->fetchTable('Users');

        $locationUsersQuery = $locationUsersTable->find()
            ->select(['username', 'location_id']);

        foreach ($locationUsersQuery as $locationUser) {
            $user = $usersTable->find()
                ->select(['id'])
                ->where(['username' => $locationUser->username])
                ->first();

            if ($user) {
                $locationsUser = $locationsUsersTable->newEmptyEntity();
                $locationsUser->location_id = $locationUser->location_id;
                $locationsUser->user_id = $user->id;

                if (!$locationsUsersTable->save($locationsUser)) {
                    $io->err(sprintf('Error saving locations_user record for user %s and location %s', $locationUser->username, $locationUser->location_id));
                }
            } else {
                $io->err(sprintf('Could not find user record for username %s', $locationUser->username));
            }
        }

        $io->out('Done!');
    }
}
