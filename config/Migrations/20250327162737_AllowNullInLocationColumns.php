<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AllowNullInLocationColumns extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up(): void
    {
        // Allow null strings in Locations table
        $table = $this->table('locations');
        $columns = $table->getColumns();
        $count = 0;
        foreach ($columns as $column) {
            $type = $column->getType();
            $identity = $column->getIdentity();
            $null = $column->getNull();
            // Find all columns that are 'string' and are not the primary key
            if (($type == 'string') && ($identity != 1) && ($null != 1)) {
                // Allow null
                $name = $column->getName();
                $default = $column->getDefault();
                $limit = $column->getLimit();
                $table->changeColumn($name, $type, [
                    'null' => true,
                    'default' => $default,
                    'limit' => $limit
                ]);
                $count++;
            }
        }
        pr($count.' columns updated in locations table');
        $table->update();

        // Allow null strings in Users table
        $table = $this->table('users');
        $columns = $table->getColumns();
        $count = 0;
        foreach ($columns as $column) {
            $type = $column->getType();
            $identity = $column->getIdentity();
            $null = $column->getNull();
            // Find all columns that are 'string' and are not the primary key
            if (($type == 'string') && ($identity != 1) && ($null != 1)) {
                // Allow null
                $name = $column->getName();
                $default = $column->getDefault();
                $limit = $column->getLimit();
                $table->changeColumn($name, $type, [
                    'null' => true,
                    'default' => $default,
                    'limit' => $limit
                ]);
                $count++;
            }
        }
        pr($count.' columns updated in users table');
        $table->update();
    }

    public function down(): void
    {
    }
}
