<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveConsumerGuideIdFromWikis extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up()
    {
        $table = $this->table('wikis');
        $table->removeColumn('consumer_guide_id')->save();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down()
    {
        $table = $this->table('wikis');
        $table
            ->addColumn('consumer_guide_id', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
                'after' => 'user_id'
            ])
            ->update();
    }
}
