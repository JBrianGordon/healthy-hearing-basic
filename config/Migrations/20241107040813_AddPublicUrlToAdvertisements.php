<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddPublicUrlToAdvertisements extends AbstractMigration
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
        $table = $this->table('advertisements');
        $table->addColumn('public_url', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'src',
            ]);
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('advertisements');
        $table->removeColumn('public_url');
        $table->save();
    }
}
