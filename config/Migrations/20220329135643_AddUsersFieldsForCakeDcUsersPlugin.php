<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddUsersFieldsForCakeDcUsersPlugin extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('users')
            ->addColumn('token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('token_expires', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('api_token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('activation_date', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('tos_date', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('is_superuser', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('role', 'string', [
                'default' => 'user',
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('secret', 'string', [
                'after' => 'activation_date',
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('secret_verified', 'boolean', [
                'after' => 'secret',
                'default' => null,
                'null' => true,
            ])
            ->addColumn('additional_data', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->update();
    }
}
