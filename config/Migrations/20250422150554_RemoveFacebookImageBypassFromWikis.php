<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveFacebookImageBypassFromWikis extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('wikis');
        $table->removeColumn('facebook_image_bypass');
        $table->save();
    }

    public function down()
    {
        $table = $this->table('wikis');
        $table->addColumn('facebook_image_bypass', 'boolean', [
            'default' => true,
            'limit' => null,
            'null' => true,
            'after' => 'facebook_image_url',
        ]);

        $table->save();
    }
}
