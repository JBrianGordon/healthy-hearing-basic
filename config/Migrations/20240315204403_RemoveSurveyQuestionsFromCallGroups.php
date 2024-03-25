<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveSurveyQuestionsFromCallGroups extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        // Remove fields from Call Groups table
        $table = $this->table('ca_call_groups');
        $table->removeColumn('question_visit_clinic')
            ->removeColumn('question_what_for')
            ->removeColumn('question_purchase')
            ->removeColumn('question_brand')
            ->removeColumn('question_brand_other')
            ->removeColumn('clinic_outbound_count')
            ->removeColumn('patient_outbound_count');
        $table->save();

        // If status is related to surveys, replace it with 'appt_set'
        $builder = $this->getQueryBuilder();
        $builder
            ->update('ca_call_groups')
            ->set('status', 'appt_set')
            ->where(['status IN' => [
                'outbound_clinic_attempted',
                'outbound_clinic_too_many_attempts',
                'outbound_clinic_declined',
                'outbound_clinic_complete',
                'outbound_cust_attempted',
                'outbound_cust_declined',
                'outbound_cust_complete',
                'outbound_cust_too_many_attempts'
                ]])
            ->execute();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('ca_call_groups');
        $table->addColumn('question_visit_clinic', 'string')
            ->addColumn('question_what_for', 'string')
            ->addColumn('question_purchase', 'string')
            ->addColumn('question_brand', 'string')
            ->addColumn('question_brand_other', 'string')
            ->addColumn('clinic_outbound_count', 'integer')
            ->addColumn('patient_outbound_count', 'integer');
        $table->save();
    }
}
