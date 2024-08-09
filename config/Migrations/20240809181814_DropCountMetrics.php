<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class DropCountMetrics extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('count_metrics');
        $table->drop()->save();
    }

    public function down(): void
    {
        $table = $this->table('count_metrics')
            ->addColumn('type', 'string', [
                'default' => '',
                'limit' => 16,
                'null' => false,
            ])
            ->addColumn('metric', 'string', [
                'default' => '',
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 128,
                'null' => false,
            ])
            ->addColumn('sub_name', 'string', [
                'default' => '',
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('count', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('updated', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();
    }
}
