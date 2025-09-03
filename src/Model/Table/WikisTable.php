<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Search\Model\Filter\Base;
use ArrayObject;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use App\Utility\Adapter\CKBoxAdapter;
use App\Utility\CKBoxUtility;
use Cake\Cache\Cache;

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
        ]);

        $this->addBehavior('Draft',[
            'ckImageKeys' => [
                'facebook_image_name' => 'facebook_image_url',
            ],
        ]);
        // HACK for custom isUnique rule (see rule below).
        // 'id_draft_parent' is temporarily set to 1 so that the draft can save
        // w/o failing the unique slug rule, before being immediately overwritten
        // by the actual draft parent ID in the DraftBehavior.
        // It looks like the CakePHP 5.x - compatible version of Duplicatable
        // can pass the $original item in the 'set' config:
        // https://github.com/riesenia/cakephp-duplicatable
        // Please update when we make it to 5.x :)
        $this->addBehavior('Duplicatable.Duplicatable', [
            'contain' => [
                'Contributors', 'Reviewers', 'Tags'
            ],
            'set' => [
                'is_active' => 0,
                'id_draft_parent' => 1,
                'last_modified' => FrozenTime::now()->addDays(30)->format('Y-m-d H:i:s'),
            ],
        ]);
        $this->addBehavior('Sitemap.Sitemap', [
            'conditions' => [
                'is_active' => true,
                'id_draft_parent' => 0,
            ],
            'order' => [
                'priority' => 'ASC',
                'name' => 'ASC',
            ],
        ]);

        // $this->addBehavior('Josegonzalez/Upload.Upload', [
        //     'facebook_image_name' => [
        //         'writer' => 'App\Utility\Writer\CkBoxWriter',
        //         'filesystem' => [
        //             'adapter' => new CKBoxAdapter(Configure::read('CK.wikis-uploads')),
        //         ],
        //         'path' => '',
        //         'keepFilesOnDelete' => false,
        //         'nameCallback' => function ($table, $entity, $data, $field, $settings) {
        //             $filename = $data->getClientFilename();
        //             $basename = pathinfo($filename, PATHINFO_FILENAME);
        //             $extension = pathinfo($filename, PATHINFO_EXTENSION);
        //             return $basename . '-' . uniqid() . '.' . $extension;
        //         },
        //         'deleteCallback' => function ($path, $entity, $field, $settings) {
        //             if (!empty($entity->facebook_image_url)) {
        //                 preg_match("/assets\/(.*?)\/file/", $entity->facebook_image_url, $matches);
        //                 $ckBoxImageId = $matches[1];
        //                 return [
        //                     $ckBoxImageId,
        //                 ];
        //             }
        //             return [];
        //         }
        //     ],
        // ]);

        $this->belongsTo('Author', [
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
            ->like('name', [
                'before' => true,
                'after' => true,
            ])
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
            ->like('title_head', [
                'before' => true,
                'after' => true,
            ])
            ->boolean('facebook_image')
            ->add('created_date_range', 'Search.Callback', [
                'callback' => function (Query $query, array $args, Base $filter) {
                    [$start, $end] = explode(',', $args['created_date_range']);
                    $startDate = (new FrozenTime($start));
                    $endDate = (new FrozenTime($end));
                    $query->where(function (QueryExpression $exp, Query $q) use ($startDate, $endDate) {
                        return $exp->between('Wikis.created', $startDate, $endDate, 'date');
                    });
                },
            ])
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['name', 'slug', 'short'],
            ]);
    }

    public function getAdvSearchFields()
    {
        // Get search fields from Search behavior config
        $advSearchFields = $this->searchManager()
            ->getFilters()
            ->getIterator();

        // Remove multi-field query
        $advSearchFields->offsetUnset('q');

        // Retrieve array from Iterator
        $advSearchFields = array_keys($advSearchFields->getArrayCopy());

        // Remove '_date_range' from any datetime range
        // search filters
        $advSearchFields = array_map(function($value) {
            return str_replace('_date_range', '', $value);
        }, $advSearchFields);

        $tableSchema = $this->getSchema()->typeMap();

        // Return advanced search fields w/data types
        return array_intersect_key(
            $tableSchema,
            array_flip($advSearchFields)
        );
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', true, 'Name is a required field')
            ->notEmptyString('name', 'Name cannot be left blank');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', true, 'Slug is a required field')
            ->notEmptyString('slug', 'Slug cannot be left blank')
            ->add('slug', [
                'validSlugChars' => [
                    'rule' => ['custom', '/^[a-zA-Z0-9\/-]+$/'],
                    'message' => 'The slug can only contain alphanumeric characters, hyphens, and forward slashes, and NO spaces.'
                ]
            ])
            ->add('slug', [
                'validSlugPrefix' => [
                    'rule' => function ($value, $context) {
                        if (stripos($value, '/') !== false) {
                            $value = substr($value, 0, stripos($value, '/'));
                        }
                        // Is this a valid slug path?
                        return in_array($value, Configure::read('wikiCategories'));
                    },
                    'message' => "The Help Page slug must begin with 'hearing-loss/' or 'hearing-aids/'"
                ]
            ]);

        $validator
            ->scalar('body')
            ->requirePresence('body', true, 'Main content section (body) is a required field')
            ->notEmptyString('body', 'Main content section (body) cannot be left blank');

        $validator
            ->integer('user_id');

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

        $validator // Facebook image only required when Wiki is active / ready to be published
            ->notEmptyString('facebook_image_name', 'must have image', function ($context) {
                return !empty($context['data']['is_active']);
            });

        $validator
            ->dateTime('last_modified')
            ->allowEmptyDateTime('last_modified')
            ->requirePresence('last_modified', true, 'Last modified is a required field')
            ->notEmptyString('last_modified', 'Last modified cannot be left blank');

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
        // Custom isUnique rule that skips uniqe check if id_draft_parent > 0
        // An OOTB isUnique check causes draft creation to fail because drafts
        // share slugs with their parents.
        // HACK REQUIRED -- see Duplicatable config above
        $rules->add(
            function ($entity, $options) {
                if ($entity->id_draft_parent > 0) {
                    return true;
                }

                // Perform the unique check
                if ($entity->isNew()) {
                    $existing = $this->find()
                        ->where(['slug' => $entity->slug])
                        ->first();
                } else {
                    $existing = $this->find()
                        ->where(['slug' => $entity->slug])
                        ->where(['id !=' => $entity->id])
                        ->where(['id_draft_parent !=' => $entity->id])
                        ->first();
                }

                return $existing === null ? true : 'This Help page slug is already being used.';
            },
            'isUniqueSlug',
            [
                'errorField' => 'slug'
            ]
        );

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
            'contain' => ['Author','Tags','Contributors','Reviewers']
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
