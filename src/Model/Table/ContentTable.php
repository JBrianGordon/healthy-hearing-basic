<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
use Cake\Validation\Validator;
use Cake\Routing\Router;
use Search\Model\Filter\Base;
use ArrayObject;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use App\Utility\Adapter\CKBoxAdapter;
use App\Utility\CKBoxUtility;

/**
 * Content Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 * @method \App\Model\Entity\Content newEmptyEntity()
 * @method \App\Model\Entity\Content newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Content[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Content get($primaryKey, $options = [])
 * @method \App\Model\Entity\Content findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Content patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Content[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Content|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Content saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \App\Model\Behavior\DraftBehavior
 * @mixin \Duplicatable\Model\Behavior\DuplicatableBehavior
 */
class ContentTable extends Table
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

        $this->setTable('content');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehaviors([
            'Search.Search',
            'Timestamp',
        ]);
        $this->addBehavior('Draft',[
            'ckImageKeys' => [
                'facebook_image_name' => 'facebook_image_url',
            ],
        ]);
        $this->addBehavior('Duplicatable.Duplicatable', [
            'contain' => [
                'Contributors', 'Tags'
            ],
            'set' => [
                'is_active' => 0,
                'last_modified' => FrozenTime::now()->addDays(30)->format('Y-m-d H:i:s'),
            ],
        ]);
        $this->addBehavior('Sitemap.Sitemap', [
            'conditions' => [
                'is_active' => true,
                'is_gone' => false,
                'date <=' => date('Y-m-d'),
                'id_draft_parent' => 0,
            ],
            'fields' => ['id', 'slug', 'last_modified'],
            'order' => ['date' => 'DESC'],
        ]);

        // Associations
        $this->belongsTo('PrimaryAuthor')
            ->setClassName('Users')
            ->setForeignKey('user_id')
            ->setProperty('primary_author');

        $this->belongsToMany('Contributors')
            ->setClassName('Users')
            ->setForeignKey('content_id')
            ->setTargetForeignKey('user_id')
            ->setProperty('contributors')
            ->setThrough('ContentUsers');

        $this->belongsToMany('Tags', [
            'joinTable' => 'content_tags',
        ]);

        // Setup search filter using search manager
        $this->searchManager()
            ->value('id')
            ->value('user_id')
            ->value('type')
            ->like('title', [
                'before' => true,
                'after' => true,
            ])
            ->like('subtitle', [
                'before' => true,
                'after' => true,
            ])
            ->like('short', [
                'before' => true,
                'after' => true,
            ])
            ->like('body', [
                'before' => true,
                'after' => true,
            ])
            ->boolean('is_active')
            ->boolean('is_library_item')
            ->like('library_share_text', [
                'before' => true,
                'after' => true,
            ])
            ->boolean('is_gone')
            ->boolean('facebook_image')
            ->exists('id_draft_parent', [
                'nullValue' => '0',
            ])
            ->add('last_mod_date_range', 'Search.Callback', [
                'callback' => function (Query $query, array $args, Base $filter) {
                    [$start, $end] = explode(',', $args['last_mod_date_range']);
                    $startDate = (new FrozenTime($start));
                    $endDate = (new FrozenTime($end));
                    $query->where(function (QueryExpression $exp, Query $q) use ($startDate, $endDate) {
                        return $exp->between('last_modified', $startDate, $endDate, 'date');
                    });
                },
            ])
            ->add('created_date_range', 'Search.Callback', [
                'callback' => function (Query $query, array $args, Base $filter) {
                    [$start, $end] = explode(',', $args['created_date_range']);
                    $startDate = (new FrozenTime($start));
                    $endDate = (new FrozenTime($end));
                    $query->where(function (QueryExpression $exp, Query $q) use ($startDate, $endDate) {
                        return $exp->between('Content.created', $startDate, $endDate, 'date');
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
                'fields' => ['title', 'subtitle', 'short'],
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
        // $validator
        //     ->integer('id')
        //     ->allowEmptyString('id', null, 'create');

        // $validator
        //     ->integer('id_brafton')
        //     ->allowEmptyString('id_brafton');

        $validator
            ->scalar('type')
            ->requirePresence('type', true, 'Type is a required field')
            ->notEmptyString('type', 'Type cannot be left blank');

        $validator
            ->dateTime('date')
            ->requirePresence('date', function ($context) {
                    return !$context['data']['is_frozen'];
                },
                'Publication Date is a required field'
            );

        $validator
            ->dateTime('last_modified')
            ->requirePresence('last_modified', true, 'Last Modified is a required field')
            ->add('last_modified', 'custom', [
                'rule' => function ($value, $context) {
                    return $value >= $context['data']['date'];
                },
                'message' => 'The Last Modified date cannot be earlier than the Publication Date'
            ]);

        $validator
            ->requirePresence('title', true, 'Title is a required field')
            ->scalar('title')
            // ->maxLength('title', 128)
            ->notEmptyString('title', 'Title cannot be left blank');

        // $validator
        //     ->scalar('alt_title')
        //     ->maxLength('alt_title', 128)
        //     ->requirePresence('alt_title', 'create')
        //     ->notEmptyString('alt_title');

        // $validator
        //     ->scalar('subtitle')
        //     ->maxLength('subtitle', 128)
        //     ->requirePresence('subtitle', 'create')
        //     ->notEmptyString('subtitle');

        // $validator
        //     ->scalar('title_head')
        //     ->maxLength('title_head', 128)
        //     ->requirePresence('title_head', 'create')
        //     ->notEmptyString('title_head');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', true, 'Slug is a required field')
            ->notEmptyString('slug', 'Slug cannot be left blank');

        // $validator
        //     ->scalar('short')
        //     ->requirePresence('short', 'create')
        //     ->notEmptyString('short');

        $validator
            ->scalar('body')
            ->requirePresence('body', true, 'Main content section (body) is a required field')
            ->notEmptyString('body', 'Main content section (body) cannot be left blank');

        $validator
            ->scalar('meta_description')
            ->maxLength('meta_description', 160);

        // $validator
        //     ->scalar('bodyclass')
        //     ->maxLength('bodyclass', 64)
        //     ->requirePresence('bodyclass', 'create')
        //     ->notEmptyString('bodyclass');

        // $validator
        //     ->boolean('is_active')
        //     ->notEmptyString('is_active');

        // $validator
        //     ->boolean('is_library_item')
        //     ->notEmptyString('is_library_item');

        // $validator
        //     ->scalar('library_share_text')
        //     ->maxLength('library_share_text', 250)
        //     ->requirePresence('library_share_text', 'create')
        //     ->notEmptyString('library_share_text');

        // $validator
        //     ->boolean('is_gone')
        //     ->notEmptyString('is_gone');

        // $validator
        //     ->scalar('facebook_title')
        //     ->maxLength('facebook_title', 100)
        //     ->allowEmptyString('facebook_title');

        // $validator
        //     ->scalar('facebook_description')
        //     ->maxLength('facebook_description', 255)
        //     ->allowEmptyString('facebook_description');
////////
        // // TO-DO
        // $validator
        //     ->scalar('facebook_image')
        //     ->maxLength('facebook_image', 100)
        //     ->allowEmptyFile('facebook_image');

        $validator // Facebook image only required when Content is active / ready to be published
            ->notEmptyString('facebook_image_name', 'must have image', function ($context) {
                return !empty($context['data']['is_active']);
            });

        $validator->setProvider('upload', \Josegonzalez\Upload\Validation\ImageValidation::class);
        // $validator->add('facebook_image_name', 'fileAboveMinWidth', [
        //     'rule' => ['isAboveMinWidth', 800],
        //     'on' => function ($context) {
        //         $imageSizeGreaterThanZero = $context['data']['facebook_image_name']->getSize() > 0;
        //         $imageFilenameNotEmpty = !empty($context['data']['facebook_image_name']->getClientFilename());
        //         return ($imageSizeGreaterThanZero && $imageFilenameNotEmpty);
        //     },
        //     'message' => 'This image should at least be 800px wide',
        //     'provider' => 'upload'
        // ]);

        // $validator
        //     ->integer('facebook_image_height')
        //     ->notEmptyFile('facebook_image_height');

        // $validator
        //     ->scalar('facebook_image_alt')
        //     // ->maxLength('facebook_image_alt', 255)
        //     ->requirePresence('facebook_image_alt', true, 'Facebook image alt is a required field')
        //     ->notEmptyString('facebook_image_alt', 'Facebook image alt text cannot be left blank');

        // $validator
        //     ->boolean('old_url')
        //     ->notEmptyString('old_url');

        // $validator
        //     ->integer('id_draft_parent')
        //     ->notEmptyString('id_draft_parent');

        // $validator
        //     ->boolean('is_frozen')
        //     ->allowEmptyString('is_frozen');

        // // TO-DO
        // $validator for 'user_id' in addition to rules checker
        $validator
            ->integer('user_id');

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

    /**
    * Find latest content based on date
    */
    public function findLatest($count = 0){
        if ($count) {
            // TODO: 'short' configuration for cache
            if ($cache = Cache::read('latest_' . $count/*, 'short'*/)) {
                return $cache;
            }
            $retval = $this->find('all', [
                'conditions' => ['Content.is_active' => true, 'Content.last_modified <= CURDATE()'],
                'contain' => ['PrimaryAuthor'],
                'order' => 'Content.last_modified DESC',
                'limit' => $count
            ])->all();

            Cache::write('latest_' . $count, $retval/*, 'short'*/);
            return $retval;
        }
        return [];
    }

    /**
    * Find content by Tag
    * @param mixed. array of options or string of single tag.
    * - tags array of tags
    * - count (default 5)
    * - fields
    * - contain (default Tag)
    * - strict (default true) if false keep going until we get count popping off tags.
    * - order (default Content.date DESC)
    * @return array of results
    */
    function findByTags($tagIds=[], $limit=6){
        // TODO: We previously used find('similar')
        // Test to see how close this is
        if (empty($tagIds)) {
            return [];
        }

        $contentTags = $this->Tags->find()
            ->contain(['Content' => function ($q) {
                return $q->where([
                    'Content.is_active' => true,
                    'Content.last_modified <=' => date('Y-m-d')
                ]);
            }])
            ->where(['Tags.id IN' => $tagIds])
            ->all();

        $contents = [];
        $contentIds = [];

        // TO-DO: This loop was causing errors with how it was trying to read
        // contentTag 'id' values (doing it the Cake 2 way?). Beyond that,
        // I'm not sure what this block is doing, since I think Wikis can only
        // have one tag (is that right?) (BT).
        foreach ($contentTags as $contentTag) {
            if (!in_array($contentTag->id, $contentIds)) {
                $contentIds[] = $contentTag->id;
                $contents[] = $contentTag->content;
            }
        }

        $contents = $contents[0];
        usort ($contents, function($first,$second) {
            return $second->last_modified->timestamp <=> $first->last_modified->timestamp;
        });

        $contents = array_slice($contents, 0, $limit);
        return $contents;
    }

    /**
    * Find a content based off it's id and uri
    * @param id
    * @param current here
    * @return array of result
    */
    function findByIdSlug($id = null, $uri = null){
        if ($uri == Router::url($this->findForRedirectById($id))) {
            return $this->find('all', [
                'conditions' => [
                    'Content.id' => (int) $id,
                    'Content.last_modified <= CURDATE()',
                    'Content.is_active' => true
                ],
                'contain' => ['Tags','PrimaryAuthor','Contributors']
            ])->first();
        }
        return array();
    }

    /**
    * Find the redirect based off an id and must be published.
    * @param int id
    * @return string hh or false
    */
    function findForRedirectById($id){
        $content = $this->find('all', array(
            'conditions' => [
                'Content.id' => (int) $id,
                'Content.date <= CURDATE()'
            ],
            'contain' => [],
            'fields' => [
                'Content.slug',
                'Content.id',
                'Content.type',
                'Content.old_url',
                'Content.is_active'
            ]
        ))->first();
        if (isset($content->hh_url)) {
            return $content->hh_url;
        }
        return false;
    }

    /**
    * Takes an ID of content or a list of tags and outputs the
    * @param entity $content with tags associated
    * @return string of tags for custom vars
    */
    public function tagsForCustomVar($content){
        if (!is_object($content)) {
            $content = $this->find('all', [
                'conditions' => ['Content.id' => $content],
                'contain' => ['Tags']
            ])->first();
        }
        //Parse Tags into string for customVar
        $retval = [];
        $tags = empty($content->tags) ? [] : $content->tags;
        foreach ($tags as $tag) {
            $retval[] = $tag->name;
        }
        return implode(',', $retval);
    }

    /**
    * Get all wikis this content belongs to
    * @param int id
    * @return array of wiki links.
    */
    public function findWikisById($id = null){
        $retval = [];
        if ($id) {
            $contentTags = $this->ContentTags->find('all', array(
                'conditions' => ['ContentTags.content_id' => $id],
            ))->all();
            //$TagWikis = TableRegistry::get('TagWikis');
            $wikiIds = array();
            foreach ($contentTags as $tag) {
                $tagWiki = TableRegistry::get('TagWikis')->find()->where(['tag_id' => $tag->tag_id])->first();
                if (!empty($tagWiki->wiki_id)) {
                    $wikiIds[] = $tagWiki->wiki_id;
                }
            }
            if (!empty($wikiIds)) {
                $retval = TableRegistry::get('Wikis')->findForLinkByIds($wikiIds);
            }
        }
        return $retval;
    }
}
