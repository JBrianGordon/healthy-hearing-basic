<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
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

/**
 * LocationPhotos Model
 *
 * @property \App\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\LocationPhoto newEmptyEntity()
 * @method \App\Model\Entity\LocationPhoto newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LocationPhoto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LocationPhoto get($primaryKey, $options = [])
 * @method \App\Model\Entity\LocationPhoto findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LocationPhoto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LocationPhoto[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LocationPhoto|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationPhoto saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LocationPhoto[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationPhoto[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationPhoto[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LocationPhoto[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LocationPhotosTable extends Table
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

        $this->setTable('location_photos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'photo_name' => [
                'writer' => 'App\Utility\Writer\CkBoxWriter',
                'filesystem' => [
                    'adapter' => new CKBoxAdapter(Configure::read('CK.locationPhotos-uploads')),
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
                    preg_match("/assets\/(.*?)\/file/", $entity->photo_url, $matches);
                    $ckBoxImageId = $matches[1];
                    return [
                        $ckBoxImageId,
                    ];
                }
            ],
        ]);

        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'LEFT',
        ]);
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isDirty('photo_name') && $entity->ajax_delete !== true) {
            $filename = pathinfo($entity->photo_name, PATHINFO_FILENAME);

            $ckBoxUploadData = Cache::read('ckBoxUploadImage_' . $filename, 'default');

            $publicUrl = $ckBoxUploadData['response']['url'];

            if ($publicUrl !== null && is_string($publicUrl)) {
                $entity->photo_url = $ckBoxUploadData['response']['url'];
            }

            Cache::delete('ckBoxUploadImage_' . $filename);
        }
    }

    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $field = 'photo_name';

        $original = $entity->getOriginal($field);

        if ($entity->{$field} !== $original && $original !== null && is_object($original) === false) {
            preg_match("/assets\/(.*?)\/file/", $entity->getOriginal('photo_url'), $matches);
            $ckBoxImageId = $matches[1];
            $ckBoxUtility = new CKBoxUtility(Configure::read('CK.locationPhotos-uploads'));
            try {
                $ckBoxUtility->deleteImage($ckBoxImageId);
            } catch (Exception $e) {
                // TODO
                // Ignore exceptions for now
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
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        // TODO: ADD VALIDATION FOR PHOTO_NAME

        $validator
            ->scalar('photo_url')
            ->maxLength('photo_url', 128)
            ->allowEmptyString('photo_url');

        $validator
            ->scalar('alt')
            ->maxLength('alt', 100)
            ->allowEmptyString('alt');

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
        $rules->add($rules->existsIn('location_id', 'Locations'), ['errorField' => 'location_id']);

        return $rules;
    }
}
