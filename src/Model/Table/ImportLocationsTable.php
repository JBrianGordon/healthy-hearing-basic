<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\Validation\Validator;

/**
 * ImportLocations Model
 *
 * @property \App\Model\Table\ImportsTable&\Cake\ORM\Association\BelongsTo $Imports
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\ImportLocationProvidersTable&\Cake\ORM\Association\HasMany $ImportLocationProviders
 *
 * @method \App\Model\Entity\ImportLocation newEmptyEntity()
 * @method \App\Model\Entity\ImportLocation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocation get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImportLocation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ImportLocation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImportLocation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportLocation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ImportLocation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ImportLocationsTable extends Table
{
    public $fields = [];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('import_locations');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');

        $titleLabel = Configure::read('isYhnImportEnabled') ? 'Practice Name' : 'Title';
        $subtitleLabel = Configure::read('isYhnImportEnabled') ? 'Location Name<br><small>not shown</small>' : 'Subtitle <small>not shown</small>';
        $this->fields = [
            [
                'label' => $titleLabel,
                'hh'    => 'title',
            ],
            [
                'label' => $subtitleLabel,
                'hh'    => 'subtitle',
            ],
            [
                'label' => 'Phone',
                'hh'    => 'phone',
            ],
            [
                'label' => 'Email',
                'hh'    => 'email',
            ],
            [
                'label' => 'Address 1',
                'hh'    => 'address',
            ],
            [
                'label' => 'Address 2',
                'hh'    => 'address_2',
            ],
            [
                'label' => 'City',
                'hh'    => 'city',
            ],
            [
                'label' => Configure::read('stateLabel'),
                'hh'    => 'state',
            ],
            [
                'label' => ucwords(Configure::read('zipShort')),
                'hh'    => 'zip',
            ],
            [
                'label' => 'Is Retail',
                'hh'    => 'is_retail',
                'boolean' => true,
            ],
            [
                'label' => 'Oticon ID<br><small>not shown</small>',
                'hh'    => 'id_oticon',
            ],
        ];
        if (Configure::read('isCqpImportEnabled')) {
            $this->fields[] = [
                'label' => 'CQP Practice ID<br><small>not shown</small>',
                'hh'    => 'id_cqp_practice',
            ];
            $this->fields[] = [
                'label' => 'CQP Office ID<br><small>not shown</small>',
                'hh'    => 'id_cqp_office',
            ];
        }

        $this->belongsTo('Imports', [
            'foreignKey' => 'import_id',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
        ]);
        $this->hasMany('ImportLocationProviders', [
            'foreignKey' => 'import_location_id',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->value('import_id', ['multiValue' => true])
            ->value('id_external')
            ->value('location_id')
            ->value('id_oticon')
            ->value('id_cqp_practice')
            ->value('id_cqp_office')
            ->like('title')
            ->like('subtitle')
            ->like('email')
            ->like('address')
            ->like('address_2')
            ->like('city')
            ->value('state')
            ->value('zip')
            ->value('phone')
            ->value('match_type')
            ->boolean('is_retail')
            ->boolean('is_new')
            ->value('notes')
            ->value('Imports.type')
            ->exists('location_exists', ['fields' => 'location_id'])
            ->value('Locations.is_junk')
            ->value('Locations.review_needed');
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('id_external')
            ->maxLength('id_external', 50)
            ->allowEmptyString('id_external');

        $validator
            ->scalar('id_oticon')
            ->maxLength('id_oticon', 255)
            ->allowEmptyString('id_oticon');

        $validator
            ->scalar('id_cqp_practice')
            ->maxLength('id_cqp_practice', 255)
            ->allowEmptyString('id_cqp_practice');

        $validator
            ->scalar('id_cqp_office')
            ->maxLength('id_cqp_office', 255)
            ->allowEmptyString('id_cqp_office');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('subtitle')
            ->maxLength('subtitle', 255)
            ->allowEmptyString('subtitle');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('address_2')
            ->maxLength('address_2', 255)
            ->allowEmptyString('address_2');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->allowEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->allowEmptyString('state');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 255)
            ->allowEmptyString('zip');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 255)
            ->allowEmptyString('phone');

        $validator
            ->integer('match_type')
            ->allowEmptyString('match_type');

        $validator
            ->boolean('is_retail')
            ->notEmptyString('is_retail');

        $validator
            ->boolean('is_new')
            ->notEmptyString('is_new');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

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
        $rules->add($rules->existsIn('import_id', 'Imports'), ['errorField' => 'import_id']);
        $rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }

    public function typeSearch($type)
    {
        $type = !empty($type) ? $type : 'all';
        $requestParams = [];
        if ($type == 'unlinked') {
            $requestParams['location_exists'] = 0;
        }
        if ($type == 'review-needed') {
            $requestParams['location_exists'] = 1;
            $requestParams['Locations']['review_needed'] = 1;
            $requestParams['Locations']['is_junk'] = 0;
        }
        if ($type == 'reviewed') {
            $requestParams['location_exists'] = 1;
            $requestParams['Locations']['review_needed'] = 0;
            $requestParams['Locations']['is_junk'] = 0;
        }
        if ($type == 'junk') {
            $requestParams['location_exists'] = 1;
            $requestParams['Locations']['is_junk'] = 1;
        }
        return $requestParams;
    }
}
