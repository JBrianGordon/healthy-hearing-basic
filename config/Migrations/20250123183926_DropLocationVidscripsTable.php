<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class DropLocationVidscripsTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('location_vidscrips')->drop()->save();
    }

    public function down(): void
    {
        $this->table('location_vidscrips')
            ->addColumn('id', 'integer', ['signed' => false, 'autoIncrement' => true])
            ->addColumn('location_id', 'biginteger', ['default' => 0])
            ->addColumn('vidscrip', 'string', ['limit' => 30, 'null' => true, 'default' => null])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addPrimaryKey(['id'])
            ->create();
    }
}
?>
