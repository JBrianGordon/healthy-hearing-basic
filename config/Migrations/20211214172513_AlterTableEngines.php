<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AlterTableEngines extends AbstractMigration
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
        // Change all table engines to InnoDB
        $tables = ['advertisements', 'advertisements_clicks', 'call_sources', 'ca_call_group_notes', 'ca_call_groups', 'ca_calls', 'call_sources', 'cities', 'configurations', 'content', 'content_locations', 'content_tags', 'content_users', 'corps', 'corps_users', 'crm_searches', 'cs_calls', 'drafts', 'icing_versions', 'import_status', 'location_ads', 'location_emails', 'location_hours', 'location_notes', 'location_photos', 'location_user_logins', 'location_users', 'location_videos', 'location_vidscrips', 'locations', 'providers', 'queue_task_logs', 'queue_tasks', 'quiz_results', 'reviews', 'schema_migrations', 'seo_blacklists', 'seo_canonicals', 'seo_honeypot_visits', 'seo_meta_tags', 'seo_redirects', 'seo_search_terms', 'seo_status_codes', 'seo_titles', 'seo_uris', 'sitemap_urls', 'tag_ads', 'tag_wikis', 'tags', 'users', 'users_wikis', 'wikis', 'zipcodes'];
        foreach ($tables as $tableName) {
            try {
                $count = $this->execute('ALTER TABLE '.$tableName.' ENGINE=InnoDB');
                echo $tableName.' ';
            } catch(Exception $e) {
                $table = $this->table($tableName, ['engine' => 'InnoDB']);
                $table->create();
                pr('Warning: table '.$tableName.' does not exist. Creating it.');
            }
        }
        pr('Done');
    }
}
