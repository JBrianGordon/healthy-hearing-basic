<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddPhotoNameToLocationPhotos extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('location_photos');
        $table->addColumn('photo_name', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'location_id',
            ]);
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('location_photos');
        $table->removeColumn('photo_name');
        $table->save();
    }
}
