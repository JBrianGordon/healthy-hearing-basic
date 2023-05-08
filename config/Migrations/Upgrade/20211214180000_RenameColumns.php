<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RenameColumns extends AbstractMigration
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
        try {
            $this->table('ca_call_groups')
                ->renameColumn('locked_by_user_id', 'id_locked_by_user')
                ->renameColumn('xml_file_id', 'id_xml_file')
                ->update();
            $this->table('content')
                ->renameColumn('brafton_id', 'id_brafton')
                ->renameColumn('draft_parent_id', 'id_draft_parent')
                ->update();
            $this->table('corps')
                ->renameColumn('order', 'priority')
                ->renameColumn('old_id', 'id_old')
                ->renameColumn('draft_parent_id', 'id_draft_parent')
                ->update();
            $this->table('crm_searches')
                ->renameColumn('order', 'priority')
                ->update();
            $this->table('drafts')
                ->renameColumn('model_id', 'id_model')
                ->update();
            $this->table('icing_versions')
                ->renameColumn('model_id', 'id_model')
                ->update();
            $this->table('import_diffs')
                ->renameColumn('model_id', 'id_model')
                ->update();
            $this->table('import_locations')
                ->renameColumn('external_id', 'id_external')
                ->renameColumn('oticon_id', 'id_oticon')
                ->renameColumn('cqp_practice_id', 'id_cqp_practice')
                ->renameColumn('cqp_office_id', 'id_cqp_office')
                ->update();
            $this->table('import_providers')
                ->renameColumn('external_id', 'id_external')
                ->update();
            $this->table('location_links')
                ->renameColumn('linked_location_id', 'id_linked_location')
                ->update();
            $this->table('locations')
                ->renameColumn('oticon_id', 'id_oticon')
                ->renameColumn('parent_id', 'id_parent')
                ->renameColumn('sf_id', 'id_sf')
                ->renameColumn('yhn_location_id', 'id_yhn_location')
                ->renameColumn('cqp_practice_id', 'id_cqp_practice')
                ->renameColumn('cqp_office_id', 'id_cqp_office')
                ->renameColumn('coupon_id', 'id_coupon')
                ->update();
            $this->table('providers')
                ->renameColumn('order', 'priority')
                ->renameColumn('yhn_provider_id', 'id_yhn_provider')
                ->update();
            $this->table('users')
                ->renameColumn('is_active', 'active')
                ->renameColumn('lastlogin', 'last_login')
                ->update();
            $this->table('wikis')
                ->renameColumn('order', 'priority')
                ->renameColumn('draft_parent_id', 'id_draft_parent')
                ->update();
        } catch(Exception $e) {
            pr("Error: ".$e->getMessage());
        }
    }
}
