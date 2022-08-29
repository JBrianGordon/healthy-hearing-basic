<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UpdateCrmSearchModelNames extends AbstractMigration
{
    public function up()
    {
        // Update model names to plural. These are the only models currently with CRM Searches in the database.
        // 'Content' will stay the same
        $modelNameUpdates = [
            'CaCall' => 'CaCalls',
            'CaCallGroup' => 'CaCallGroups',
            'Corp' => 'Corps',
            'CrmSearch' => 'CrmSearches',
            'Location' => 'Locations',
            'Review' => 'Reviews',
        ];
        foreach ($modelNameUpdates as $oldModel => $newModel) {
            $builder = $this->getQueryBuilder();
            $builder->update('crm_searches')
                ->set('model', $newModel)
                ->where(['model' => $oldModel])
                ->execute();
        }
    }

    public function down()
    {
    }
}
