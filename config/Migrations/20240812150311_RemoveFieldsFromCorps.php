<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveFieldsFromCorps extends AbstractMigration
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
        $table = $this->table('corps');
        $table->removeColumn('type');
        $table->removeColumn('abbr');
        $table->removeColumn('notify_email');
        $table->removeColumn('approval_email');
        $table->removeColumn('phone');
        $table->removeColumn('website_url');
        $table->removeColumn('website_url_description');
        $table->removeColumn('pdf_all_url');
        $table->removeColumn('favicon');
        $table->removeColumn('address');
        $table->removeColumn('id_old');
        $table->removeColumn('is_approvalrequired');
        $table->removeColumn('is_featured');
        $table->removeColumn('wbc_config');
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('corps')
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 16,
                'null' => false,
                'after' => 'user_id',
            ])
            ->addColumn('abbr', 'string', [
                'default' => null,
                'limit' => 3,
                'null' => false,
                'after' => 'slug',
            ])
            ->addColumn('notify_email', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'description',
            ])
            ->addColumn('approval_email', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'notify_email',
            ])
            ->addColumn('phone', 'string', [
                'default' => null,
                'limit' => 64,
                'null' => true,
                'after' => 'approval_email',
            ])
            ->addColumn('website_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'after' => 'phone',
            ])
            ->addColumn('website_url_description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
                'after' => 'website_url',
            ])
            ->addColumn('pdf_all_url', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'website_url_description',
            ])
            ->addColumn('favicon', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'pdf_all_url',
            ])
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
                'after' => 'favicon',
            ])
            ->addColumn('id_old', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
                'after' => 'date_approved',
            ])
            ->addColumn('is_approvalrequired', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
                'after' => 'id_old',
            ])
            ->addColumn('is_featured', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
                'after' => 'is_active',
            ])
            ->addColumn('wbc_config', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'after' => 'id_draft_parent',
            ]);
        $table->save();
    }
}
