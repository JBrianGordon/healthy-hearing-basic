<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Search\Model\Filter\Base;

/**
 * Wikis Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\TagWikisTable&\Cake\ORM\Association\HasMany $TagWikis
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 * @method \App\Model\Entity\Wiki newEmptyEntity()
 * @method \App\Model\Entity\Wiki newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Wiki[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Wiki get($primaryKey, $options = [])
 * @method \App\Model\Entity\Wiki findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Wiki patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Wiki[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Wiki|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Wiki saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Wiki[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \App\Model\Behavior\DraftBehavior
 * @mixin \Duplicatable\Model\Behavior\DuplicatableBehavior
 */
class WikisTable extends Table
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

        $this->setTable('wikis');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehaviors([
            'Timestamp',
            'Search.Search',
            'Draft',
        ]);
        $this->addBehavior('Duplicatable.Duplicatable', [
            'set' => [
                'is_active' => 0,
            ],
        ]);

        $this->belongsTo('Authors', [
            'className' => 'Users',
            'foreignKey' => 'user_id',
        ]);
        $this->belongsToMany('Tags', [
            'joinTable' => 'tag_wikis',
        ]);
        $this->belongsToMany('Contributors', [
            'className' => 'Users',
            'joinTable' => 'users_wikis',
            'targetForeignKey' => 'user_id'
        ]);
        $this->belongsToMany('Reviewers', [
            'className' => 'Users',
            'joinTable' => 'reviewers_wikis',
            'targetForeignKey' => 'user_id'
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->value('name')
            ->value('slug')
            ->value('user_id')
            ->like('body', [
                'before' => true,
                'after' => true,
            ])
            ->like('short', [
                'before' => true,
                'after' => true,
            ])
            ->boolean('is_active')
            ->exists('id_draft_parent', [
                'nullValue' => '0',
            ])
            ->value('priority')
            ->like('title_head', [
                'before' => true,
                'after' => true,
            ])
            ->like('title_h1', [
                'before' => true,
                'after' => true,
            ])
            ->like('background_file', [
                'before' => true,
                'after' => true,
            ])
            ->like('meta_description', [
                'before' => true,
                'after' => true,
            ])
            ->like('facebook_title', [
                'before' => true,
                'after' => true,
            ])
            ->boolean('facebook_image')
            ->boolean('facebook_image_bypass')
            ->value('facebook_image_width')
            ->boolean('facebook_image_height')
            ->like('facebook_image_alt', [
                'before' => true,
                'after' => true,
            ])
            ->like('facebook_description', [
                'before' => true,
                'after' => true,
            ])
            ->value('last_modified')
            ->value('modified')
            ->value('created')
            ->like('background_alt', [
                'before' => true,
                'after' => true,
            ])
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['name', 'slug', 'short', 'body'],
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', true, 'Name is a required field')
            ->notEmptyString('name', 'Name cannot be left blank');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', true, 'Slug is a required field')
            ->notEmptyString('slug', 'Slug cannot be left blank');

        $validator
            ->scalar('body')
            ->requirePresence('body', true, 'Main content section (body) is a required field')
            ->notEmptyString('body', 'Main content section (body) cannot be left blank');

        // $validator
        //     ->scalar('short')
        //     ->allowEmptyString('short');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        // $validator
        //     ->integer('id_draft_parent')
        //     ->notEmptyString('id_draft_parent');

        $validator
            ->integer('priority')
            ->notEmptyString('priority');

        $validator
            ->scalar('title_head')
            ->maxLength('title_head', 255)
            ->requirePresence('title_head', true, 'Title head is a required field')
            ->notEmptyString('title_head', 'Title head cannot be left blank');

        $validator
            ->scalar('title_h1')
            ->maxLength('title_h1', 255)
            ->requirePresence('title_h1', true, 'Title H1 is a required field')
            ->notEmptyString('title_h1', 'Title H1 cannot be left blank');

        // $validator
        //     ->scalar('background_file')
        //     ->maxLength('background_file', 255)
        //     ->allowEmptyFile('background_file');

        // $validator
        //     ->scalar('meta_description')
        //     ->maxLength('meta_description', 255)
        //     ->allowEmptyString('meta_description');

        // $validator
        //     ->scalar('facebook_title')
        //     ->maxLength('facebook_title', 255)
        //     ->allowEmptyString('facebook_title');

        $validator
            ->scalar('facebook_image')
            ->maxLength('facebook_image', 255)
            ->notEmptyFile('facebook_image');
            // ADD MIME TYPE CHECKING

        // $validator
        //     ->boolean('facebook_image_bypass')
        //     ->allowEmptyFile('facebook_image_bypass');

        $validator
            ->integer('facebook_image_width')
            ->add('facebook_image_width', 'facebookImageGreaterThan800px', [
                'rule' => function ($width) {
                    if ($width >= 800) {
                        return true;
                    }

                    return false;
                },
            ]);
            // ->minLength('facebook_image_width', 800, 'Facebook image must be at least 800 px wide');

        // $validator
        //     ->integer('facebook_image_height')
        //     ->notEmptyFile('facebook_image_height');

        $validator
            ->scalar('facebook_image_alt')
            ->maxLength('facebook_image_alt', 255)
            ->requirePresence('facebook_image_alt', true, 'Facebook image alt text is a required field')
            ->notEmptyString('facebook_image_alt', 'Facebook image alt text cannot be left blank');

        // $validator
        //     ->scalar('facebook_description')
        //     ->maxLength('facebook_description', 255)
        //     ->allowEmptyString('facebook_description');

        $validator
            ->dateTime('last_modified')
            ->allowEmptyDateTime('last_modified')
            ->requirePresence('last_modified', true, 'Last modified is a required field')
            ->notEmptyString('last_modified', 'Last modified cannot be left blank');

        // $validator
        //     ->scalar('background_alt')
        //     ->maxLength('background_alt', 150)
        //     ->requirePresence('background_alt', 'create')
        //     ->notEmptyString('background_alt');

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
        // $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    public function findForIndex() {
        //Grab all the parents first in the order we want them in.
        $parents = $this->find('all', array(
            'conditions' => array(
                'Wikis.is_active' => true,
                'Wikis.slug NOT LIKE' => '%/%'
            ),
            'fields' => array('Wikis.slug'),
            'order' => ['Wikis.priority' => 'ASC', 'Wikis.slug' => 'ASC']
        ))->all();
        $retval = array();
        $hideSlugs = [];
        if (!Configure::read('showAssistiveListening')) {
            $hideSlugs[] = 'assistive-listening-devices';
        }
        if (!Configure::read('showTinnitus')) {
            $hideSlugs[] = 'tinnitus';
        }
        foreach($parents as $parent) {
            if (in_array($parent->slug, $hideSlugs)) {
                continue;
            }
            $retval[] = $this->findNavBySlug($parent->slug);
        }
        return $retval;
    }

    /**
    * Find navigation bar of other wikis based on the given slug.
    * @param string slug.
    * @return array of navigation.
    */
    public function findNavBySlug($slug = null) {
        $retval = array(
            'parent' => [],
            'children' => []
        );
        $parts = explode("/",$slug);
        $parentSlug = array_shift($parts);
        $retval = array(
            'parent' => $this->findForLinkBySlug($parentSlug),
            'children' => $this->findForLinkBySlug($parentSlug.'/%', true)
        );
        return $retval;
    }

    /**
    * Find for a link by the slug
    * @param string slug
    * @param bool findAll - true to find all, false to find first (default)
    * @return array of result with only name and slug returned.
    */
    public function findForLinkBySlug($slug = null, $findAll=false) {
        $wikiQuery = $this->find('all', [
            'conditions' => [
                'is_active' => true,
                'slug LIKE' => $slug
            ],
            'fields' => ['name', 'slug', 'short'],
            'order' => ['priority ASC, name ASC']
        ]);
        if ($findAll) {
            $retval = $wikiQuery->all();
        } else {
            $retval = $wikiQuery->first();
        }
        return $retval;
    }

    public function findRedirectBySlug($slug = null) {
        $wiki = $this->find('all', [
            'conditions' => [
                'slug' => $slug,
                'is_active' => true
            ],
            'fields' => ['slug'],
        ])->first();
        if (!empty($wiki) && isset($wiki->hh_url)) {
            return $wiki->hh_url;
        }
        // This slug is not active. Redirect to parent.
        if (stripos($slug, '/') !== false) {
            $parentSlug = substr($slug, 0, stripos($slug, '/'));
            if (in_array($parentSlug, Configure::read('wikiCategories'))) {
                return ['prefix'=>false, 'plugin'=>false, 'controller'=>'wikis', 'action'=>'view', 'slug'=>$parentSlug];
            }
        }
        // Invalid slug
        return false;
    }

    /**
    * Find a content based off it's id and uri
    * @param id
    * @param current here
    * @return array of result
    */
    public function findBySlug($slug, $uri = null, $bypass = false) {
        $conditions = [
            'Wikis.is_active' => true,
            'Wikis.slug' => $slug
        ];
        if ($bypass) {
            unset($conditions['Wikis.is_active']);
        }
        $wiki = $this->find('all', [
            'conditions' => $conditions,
            'contain' => ['Authors','Tags','Contributors','Reviewers']
        ])->first();
        if (!empty($wiki) && $uri == Router::url(['prefix'=>false, 'plugin'=>false, 'controller' => 'wikis', 'action' => 'view', 'slug' => $wiki->slug])) {
            return $wiki;
        }
        return [];
    }

    /**
    * Takes an ID of content or a list of tags and outputs the
    * @param mixed id | content array with Tag as associated
    * @return string of tags for custom vars
    */
    public function tagsForCustomVar($wiki){
        if (!is_object($wiki)) {
            $wiki = $this->find('all', [
                'conditions' => ['Wikis.id' => $wiki],
                'contain' => ['Tags']
            ])->first();
        }
        //Parse Tags into string for customVar, wiki tags get a w- appended onto it.
        $retval = [];
        $tags = empty($wiki->tags) ? [] : $wiki->tags;
        foreach ($tags as $tag) {
            $retval[] = 'w-' . $tag->name;
        }
        return implode(',', $retval);
    }

    /**
    * Find for a link by the id
    * @param array of wikiIds
    * @return array of result with only name and slug returned.
    */
    public function findForLinkByIds($wikiIds) {
        if (!is_array($wikiIds)) {
            return [];
        }
        return $this->find('all', [
            'conditions' => [
                'is_active' => true,
                'id IN' => $wikiIds
            ],
            'fields' => ['name','title_h1','slug','priority'],
            'order' => ['priority ASC, name ASC']
        ])->all();
    }
}
