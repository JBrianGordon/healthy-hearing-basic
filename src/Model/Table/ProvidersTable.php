<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Filter\Base;

/**
 * Providers Model
 *
 * @property \App\Model\Table\ImportProvidersTable&\Cake\ORM\Association\HasMany $ImportProviders
 * @property \App\Model\Table\LocationsProvidersTable&\Cake\ORM\Association\HasMany $LocationsProviders
 *
 * @method \App\Model\Entity\Provider newEmptyEntity()
 * @method \App\Model\Entity\Provider newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Provider[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Provider get($primaryKey, $options = [])
 * @method \App\Model\Entity\Provider findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Provider patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Provider[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Provider|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Provider saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProvidersTable extends Table
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

        $this->setTable('providers');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehaviors([
            'Search.Search',
            'Timestamp',
        ]);

        // Associations
        $this->hasMany('ImportProviders', [
            'foreignKey' => 'provider_id',
        ]);
        $this->belongsToMany('Locations', [
            'foreignKey' => 'provider_id',
            'targetForeignKey' => 'location_id',
            'joinTable' => 'locations_providers',
            'through' => 'LocationsProviders',
            'cascadeCallbacks' => true
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->like('first_name', [
                'before' => true,
                'after' => true,
            ])
            ->like('middle_name', [
                'before' => true,
                'after' => true,
            ])
            ->like('last_name', [
                'before' => true,
                'after' => true,
            ])
            ->like('credentials', [
                'before' => true,
                'after' => true,
            ])
            ->like('title', [
                'before' => true,
                'after' => true,
            ])
            ->like('email', [
                'before' => true,
                'after' => true,
            ])
            ->like('description', [
                'before' => true,
                'after' => true,
            ])
            ->boolean('is_active')
            ->add('created_date_range', 'Search.Callback', [
                'callback' => function (Query $query, array $args, Base $filter) {
                    [$start, $end] = explode(',', $args['created_date_range']);
                    $startDate = (new FrozenTime($start));
                    $endDate = (new FrozenTime($end));
                    $query->where(function (QueryExpression $exp, Query $q) use ($startDate, $endDate) {
                        return $exp->between('Providers.created', $startDate, $endDate, 'date');
                    });
                },
            ])
            ->add('mod_date_range', 'Search.Callback', [
                'callback' => function (Query $query, array $args, Base $filter) {
                    [$start, $end] = explode(',', $args['mod_date_range']);
                    $startDate = (new FrozenTime($start));
                    $endDate = (new FrozenTime($end));
                    $query->where(function (QueryExpression $exp, Query $q) use ($startDate, $endDate) {
                        return $exp->between('Providers.modified', $startDate, $endDate, 'date');
                    });
                },
            ])
            ->like('aud_or_his', [
                'before' => true,
                'after' => true,
            ])
            ->callback('location_listing_type', [
                'callback' => function (\Cake\ORM\Query $query, array $args,  \Search\Model\Filter\Base $filter) {
                    $query
                        ->innerJoinWith('Locations', function (\Cake\ORM\Query $query) use ($args) {
                            return $query->where(['Locations.listing_type =' => $args['location_listing_type']]);
                        })
                        ->group('Providers.id');

                    return true;
                }
            ]);
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
            ->scalar('first_name')
            ->maxLength('first_name', 128)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('middle_name')
            ->maxLength('middle_name', 128)
            ->allowEmptyString('middle_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 128)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->scalar('credentials')
            ->maxLength('credentials', 128)
            ->allowEmptyString('credentials');

        $validator
            ->scalar('title')
            ->maxLength('title', 128)
            ->allowEmptyString('title');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('micro_url')
            ->maxLength('micro_url', 128)
            ->allowEmptyString('micro_url');

        $validator
            ->scalar('square_url')
            ->maxLength('square_url', 128)
            ->allowEmptyString('square_url');

        $validator
            ->scalar('thumb_url')
            ->maxLength('thumb_url', 128)
            ->allowEmptyString('thumb_url');

        $validator
            ->scalar('image_url')
            ->maxLength('image_url', 128)
            ->allowEmptyFile('image_url');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 16)
            ->allowEmptyString('phone');

        $validator
            ->integer('priority')
            ->notEmptyString('priority');

        $validator
            ->scalar('aud_or_his')
            ->maxLength('aud_or_his', 255)
            ->allowEmptyString('aud_or_his');

        $validator
            ->boolean('is_ida_verified')
            ->notEmptyString('is_ida_verified');

        $validator
            ->integer('id_yhn_provider')
            ->allowEmptyString('id_yhn_provider');

        return $validator;
    }
}
