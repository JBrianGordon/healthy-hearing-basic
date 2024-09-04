<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddZipsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this->table('zips')
            ->addColumn('zip', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('lat', 'float', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('lon', 'float', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('city', 'char', [
                'default' => null,
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('state', 'char', [
                'default' => null,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('areacode', 'string', [
                'default' => null,
                'limit' => 3,
                'null' => false,
            ])
            ->addColumn('country_code', 'string', [
                'limit' => 2,
                'null' => true,
            ])
            ->addIndex(
                [
                    'zip',
                    'lat',
                    'lon',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'lat',
                    'lon',
                ]
            )
            ->create();

        $this->table('zipcodes')
            ->rename('zipcodesorig')
            ->update();
    }
}
