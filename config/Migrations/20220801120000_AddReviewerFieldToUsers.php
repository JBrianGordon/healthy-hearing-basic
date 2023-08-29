<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddingReviewerFieldToUsers extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(): void
    {
        $table = $this->table('users');
        $table->addColumn('is_reviewer', 'boolean', [
                'default' => '0',
                'null' => false,
                'after' => 'is_author',
            ])
            ->addColumn('honorific_prefix', 'string', [
                'limit' => 10,
                'null' => true,
                'after' => 'is_reviewer',
            ])
            ->addColumn('alumni_of_1', 'string', [
                'limit' => 100,
                'null' => true,
                'after' => 'honorific_prefix',
            ])
            ->addColumn('alumni_of_2', 'string', [
                'limit' => 100,
                'null' => true,
                'after' => 'alumni_of_1',
            ])
            ->addColumn('alumni_of_3', 'string', [
                'limit' => 100,
                'null' => true,
                'after' => 'alumni_of_2',
            ])
            ->addColumn('short_bio', 'string', [
                'limit' => 250,
                'null' => true,
                'after' => 'bio',
            ])
            ->addIndex(['is_reviewer'])
            ->create();

        $table = $this->table('reviewers_wikis', [
                'id' => false,
                'primary_key' => ['id'],
            ]);
        $table->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('wiki_id', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(['user_id'])
            ->addIndex(['wiki_id'])
            ->create();
    }

    public function down(): void
    {
        $this->table('users')
            ->removeColumn('is_reviewer')
            ->removeColumn('honorific_prefix')
            ->removeColumn('alumni_of_1')
            ->removeColumn('alumni_of_2')
            ->removeColumn('alumni_of_3')
            ->removeColumn('short_bio')
            ->removeIndexByName('is_reviewer')
            ->save();

        $this->table('reviewers_wikis')
            ->drop()
            ->save();
    }
}