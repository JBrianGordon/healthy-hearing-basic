<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Utility\Security;

/**
 * CopyLocationUsersData command.
 */
class CopyLocationUsersDataCommand extends Command
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
        $io->out('Copying location_users data into users table...');

        $locationUsersTable = $this->fetchTable('location_users');
        $usersTable = $this->fetchTable('Users');
        $loginIpsTable = $this->fetchTable('LoginIps');

        $locationUsersQuery = $locationUsersTable->find()->all();

        foreach ($locationUsersQuery as $locationUser) {
            $locationUser['active'] = $locationUser['is_active'];
            $locationUser['last_login'] = $locationUser['lastlogin'];
            $locationUser['role'] = 'clinic';

            if ($locationUser['email'] === null) {
                $locationUser['email'] = '';
            }

            $copiedUser = $usersTable->newEntity(
                $locationUser->toArray(),
                ['validate' => false]
            );
            if ($copiedUser->getErrors()) {
                $io->out(print_r($copiedUser->getErrors()));
            }
            $copiedUser['password'] = Security::randomString(24);
            $copiedUser->setAccess('*', true);
            $copiedUser->setAccess('id', false);

            if (!$usersTable->save($copiedUser, ['checkRules' => false])) {
                $io->err(
                    sprintf(
                        'Error saving user record for user %s and location %s',
                        $copiedUser->username,
                        $copiedUser->location_id
                    )
                );
            } else {
                $loginIpsTable->updateAll(
                    ['user_id' => $copiedUser->id],
                    ['location_user_id' => $locationUser->id],
                );
            }
        }

        $io->out('Done!');
    }
}
