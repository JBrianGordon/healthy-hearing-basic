<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSeoUrls extends AbstractMigration
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
        $this->table('seo_urls')
            ->addColumn('seo_uri_i_d', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('redirect_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('redirect_is_active', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('seo_title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('seo_meta_description', 'string', [
                'default' => null,
                'limit' => 300,
                'null' => true,
            ])
            ->addColumn('is_410', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])->create();
    }
}
