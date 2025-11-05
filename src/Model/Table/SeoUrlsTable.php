<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Filter\Base;

/**
 * SeoUrls Model
 *
 * @method \App\Model\Entity\SeoUrl newEmptyEntity()
 * @method \App\Model\Entity\SeoUrl newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SeoUrl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeoUrl get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeoUrl findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SeoUrl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeoUrl[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeoUrl|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoUrl saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeoUrl[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoUrl[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoUrl[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SeoUrl[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SeoUrlsTable extends Table
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

        $this->setTable('seo_urls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehaviors([
            'Search.Search',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->like('url', [
                'before' => true,
                'after' => true,
            ])
            ->like('redirect_url', [
                'before' => true,
                'after' => true,
            ])
            ->boolean('redirect_is_active')
            ->like('seo_title', [
                'before' => true,
                'after' => true,
            ])
            ->like('seo_meta_description', [
                'before' => true,
                'after' => true,
            ])
            ->boolean('is_410')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['url', 'redirect_url', 'seo_title', 'seo_meta_description'],
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
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->scalar('redirect_url')
            ->maxLength('redirect_url', 255)
            ->allowEmptyString('redirect_url');

        $validator
            ->boolean('redirect_is_active')
            ->notEmptyString('redirect_is_active');

        $validator
            ->scalar('seo_title')
            ->maxLength('seo_title', 255)
            ->allowEmptyString('seo_title');

        $validator
            ->scalar('seo_meta_description')
            ->maxLength('seo_meta_description', 255)
            ->allowEmptyString('seo_meta_description');

        $validator
            ->boolean('is_410')
            ->notEmptyString('is_410');

        return $validator;
    }
}
