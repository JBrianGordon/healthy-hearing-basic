<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImportDiff Entity
 *
 * @property int $id
 * @property int|null $import_id
 * @property string $model
 * @property string|null $id_model
 * @property string $field
 * @property string|null $value
 * @property int|null $review_needed
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\Import $import
 */
class ImportDiff extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'import_id' => true,
        'model' => true,
        'id_model' => true,
        'field' => true,
        'value' => true,
        'review_needed' => true,
        'created' => true,
        'import' => true,
    ];
}
