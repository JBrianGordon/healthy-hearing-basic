<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Configurations Model
 *
 * @method \App\Model\Entity\Configuration newEmptyEntity()
 * @method \App\Model\Entity\Configuration newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Configuration[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Configuration get($primaryKey, $options = [])
 * @method \App\Model\Entity\Configuration findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Configuration patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Configuration[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Configuration|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Configuration saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Configuration[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Configuration[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Configuration[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Configuration[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ConfigurationsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('configurations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('value')
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

        $validator
            ->integer('priority')
            ->notEmptyString('priority');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['name']), ['errorField' => 'name']);

        return $rules;
    }

    public function load($prefix = 'CFG') {
        $settings = $this->find('all')->all();
        foreach ($settings as $variable) {
            Configure::write("$prefix.{$variable->name}",$variable->value);
        }
    }

    public function isCallTrackingBypassed() {
        $this->load('HH');
        return empty(Configure::read('HH.bypass_call_tracking')) ? false : true;
    }

    /**
    * Determine if a Configurations-table-based feature
    * is enabled (ON)
    */
    public function isFeatureEnabled($featureName) {
        $this->load('HH');
        return empty(Configure::read("HH.{$featureName}")) ? false : true;
    }

    /**
    * Determine if a Configurations-table-based feature
    * is enabled today (by day of week)
    * Monday = 1, Sunday = 7 (e.g. M-F = 1,2,3,4,5)
    */
    public function isFeatureDay($featureName) {
        $this->load('HH');
        $featureDays = Configure::read("HH.{$featureName}_days");
        if (is_null($featureDays)) {
            return true;
        }
        $featureDays = explode(",",Configure::read("HH.{$featureName}_days"));
        $today = date('N', strtotime(getCurrentEasternTime())); // numeric value for day
        return in_array($today, $featureDays);
    }

    /**
    * Determine if a Configurations-table-based feature
    * is enabled at the current time
    */
    public function isFeatureTime($featureName) {
        $this->load('HH');
        $featureTimes = [
            Configure::read("HH.{$featureName}_start_time"),
            Configure::read("HH.{$featureName}_stop_time")
        ];
        if (is_null($featureTimes[0])) {
            return true;
        }
        $startTime = $featureTimes[0];
        $stopTime = $featureTimes[1];
        $now = getCurrentEasternTime();
        if ($now > dateTimeEastern("today {$startTime}", 'Y-m-d H:i:s') && $now < dateTimeEastern("today {$stopTime}", 'Y-m-d H:i:s')){
            return true;
        }
        return false;
    }
}
