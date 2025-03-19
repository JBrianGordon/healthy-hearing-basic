<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use ArrayObject;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use App\Utility\Adapter\CKBoxAdapter;
use App\Utility\CKBoxUtility;
use Cake\Cache\Cache;
use Cake\I18n\FrozenTime;

/**
 * Corps Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\AdvertisementsTable&\Cake\ORM\Association\HasMany $Advertisements
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 * @method \App\Model\Entity\Corp newEmptyEntity()
 * @method \App\Model\Entity\Corp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Corp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Corp get($primaryKey, $options = [])
 * @method \App\Model\Entity\Corp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Corp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Corp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Corp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \App\Model\Behavior\DraftBehavior
 * @mixin \Duplicatable\Model\Behavior\DuplicatableBehavior
 */
class CorpsTable extends Table
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

        $this->setTable('corps');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehaviors([
            'Timestamp',
        ]);
        $this->addBehavior('Draft',[
            'ckImageKeys' => [
                'logo_name' => 'logo_url',
                'facebook_image_name' => 'facebook_image_url',
            ],
        ]);
        $this->addBehavior('Duplicatable.Duplicatable', [
            'contain' => [
                'Contributors'
            ],
            'set' => [
                'is_active' => 0,
                'last_modified' => FrozenTime::now()->addDays(30)->format('Y-m-d H:i:s'),
            ],
        ]);
        $this->addBehavior('Sitemap.Sitemap', [
            'conditions' => [
                'is_active' => true,
            ],
            'fields' => ['id', 'priority', 'slug', 'title'],
            'order' => ['priority' => 'ASC', 'title' => 'ASC'],
            'priority' => 0.7,
        ]);

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'logo_name' => [
                'writer' => 'App\Utility\Writer\CkBoxWriter',
                'filesystem' => [
                    'adapter' => new CKBoxAdapter(Configure::read('CK.corps-uploads')),
                ],
                'path' => '',
                'keepFilesOnDelete' => false,
                'nameCallback' => function ($table, $entity, $data, $field, $settings) {
                    $filename = $data->getClientFilename();
                    $basename = pathinfo($filename, PATHINFO_FILENAME);
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    return $basename . '-' . uniqid() . '.' . $extension;
                },
                'deleteCallback' => function ($path, $entity, $field, $settings) {
                    if (!empty($entity->logo_url)) {
                        preg_match("/assets\/(.*?)\/file/", $entity->logo_url, $matches);
                        $ckBoxImageId = $matches[1];
                        return [
                            $ckBoxImageId,
                        ];
                    }
                    return [];
                }
            ],
            'facebook_image_name' => [
                'writer' => 'App\Utility\Writer\CkBoxWriter',
                'filesystem' => [
                    'adapter' => new CKBoxAdapter(Configure::read('CK.corps-uploads')),
                ],
                'path' => '',
                'keepFilesOnDelete' => false,
                'nameCallback' => function ($table, $entity, $data, $field, $settings) {
                    $filename = $data->getClientFilename();
                    $basename = pathinfo($filename, PATHINFO_FILENAME);
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    return $basename . '-' . uniqid() . '.' . $extension;
                },
                'deleteCallback' => function ($path, $entity, $field, $settings) {
                    if (!empty($entity->facebook_image_url)) {
                        preg_match("/assets\/(.*?)\/file/", $entity->facebook_image_url, $matches);
                        $ckBoxImageId = $matches[1];
                        return [
                            $ckBoxImageId,
                        ];
                    }
                    return [];
                }
            ],
        ]);

        // Associations
        $this->belongsTo('Author')
            ->setClassName('Users')
            ->setForeignKey('user_id');

        $this->belongsToMany('Contributors')
            ->setClassName('Users')
            ->setForeignKey('corp_id')
            ->setTargetForeignKey('user_id')
            ->setProperty('contributors')
            ->setThrough('CorpsUsers');
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {

        $fields = [
            'logo_name' => 'logo_url',
            'facebook_image_name' => 'facebook_image_url'
        ];

        foreach ($fields as $filename => $fileUrl) {
            $ckBoxUploadData = [];

            if ($entity->{$filename} !== null && $entity->isDirty($filename)) {
                $ckBoxUploadData = Cache::read('ckBoxUploadImage_' . pathinfo($entity->{$filename}, PATHINFO_FILENAME), 'default');
            }

            $publicUrl = $ckBoxUploadData['response']['url'];

            if ($publicUrl !== null && is_string($publicUrl)) {
                $entity->{$fileUrl} = $ckBoxUploadData['response']['url'];
                Cache::delete('ckBoxUploadImage_' . pathinfo($entity->{$filename}, PATHINFO_FILENAME));
            }
        }
    }

    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if (! $options['skipAfterSave']) {
            $fields = [
                'logo_name' => 'logo_url',
                'facebook_image_name' => 'facebook_image_url'
            ];

            foreach ($fields as $filename => $publicUrl) {
                $original = $entity->getOriginal($filename);

                if ($entity->{$filename} !== $original && $original !== null && is_object($original) === false) {
                    preg_match("/assets\/(.*?)\/file/", $entity->getOriginal($publicUrl), $matches);
                    $ckBoxImageId = $matches[1];
                    $ckBoxUtility = new CKBoxUtility(Configure::read('CK.corps-uploads'));
                    try {
                        $ckBoxUtility->deleteImage($ckBoxImageId);
                    } catch (Exception $e) {
                        // Ignore exceptions for now
                    }
                }
            }
        }
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
        //     ->dateTime('last_modified')
        //     ->notEmptyDateTime('last_modified');

        // $validator
        //     ->integer('modified_by')
        //     ->notEmptyString('modified_by');

        $validator
            ->scalar('title')
            ->maxLength('title', 128)
            ->requirePresence('title', true, 'Title is a required field')
            ->notEmptyString('title', 'Title cannot be left blank');

        $validator
            ->integer('user_id');

        // $validator
        //     ->scalar('slug')
        //     ->maxLength('slug', 128)
        //     ->requirePresence('slug', 'create')
        //     ->notEmptyString('slug');

        // $validator
        //     ->scalar('short')
        //     ->allowEmptyString('short');

        // $validator
        //     ->scalar('description')
        //     ->allowEmptyString('description');

        // $validator
        //     ->scalar('thumb_url')
        //     ->maxLength('thumb_url', 128)
        //     ->allowEmptyString('thumb_url');

        // $validator
        //     ->scalar('facebook_title')
        //     ->maxLength('facebook_title', 100)
        //     ->allowEmptyString('facebook_title');

        // $validator
        //     ->scalar('facebook_description')
        //     ->maxLength('facebook_description', 255)
        //     ->allowEmptyString('facebook_description');

        // $validator
        //     ->scalar('facebook_image')
        //     ->maxLength('facebook_image', 100)
        //     ->allowEmptyFile('facebook_image');

        // $validator
        //     ->boolean('is_active')
        //     ->notEmptyString('is_active');

        // $validator
        //     ->integer('id_draft_parent')
        //     ->notEmptyString('id_draft_parent');

        $validator
            ->integer('priority')
            ->notEmptyString('priority', 'Priority cannot be left blank');

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

    function findBySlug($slug){
        $corp = $this->find('all', [
            'conditions' => [
                'slug' => $slug,
                'is_active' => true
            ],
            'contain' => [
                'Author',
                'Contributors'
            ]
        ])->first();
        return $corp;
    }
}
