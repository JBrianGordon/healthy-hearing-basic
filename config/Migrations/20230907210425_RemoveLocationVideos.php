<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveLocationVideos extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->table('location_videos')->drop()->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $locationVideos = $this->table('location_videos');
        $locationVideos->addColumn('location_id', 'biginteger')
            ->addIndex('location_id')
            ->addColumn('video_url', 'string')
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
