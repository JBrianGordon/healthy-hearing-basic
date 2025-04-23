<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveFacebookImageWidthOverrideFromContent extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('content');
        $table->removeColumn('facebook_image_width_override');
        $table->save();
    }

    public function down()
    {
        $table = $this->table('content');
        $table->addColumn('facebook_image_width_override', 'boolean', [
            'default' => true,
            'limit' => null,
            'null' => true,
            'after' => 'facebook_image_width',
        ]);

        $table->save();
    }
}
