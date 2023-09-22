<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Review Entity
 *
 * @property int $id
 * @property int $location_id
 * @property string|null $body
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $zip
 * @property int $rating
 * @property bool $is_spam
 * @property int $status
 * @property int $origin
 * @property string|null $response
 * @property int $response_status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $denied_date
 * @property string|null $ip
 * @property int $character_count
 *
 * @property \App\Model\Entity\Location $location
 */
class Review extends Entity
{
    public static $ratings = [
        1 => '1 (Poor)',
        2 => '2 (Below average)',
        3 => '3 (Average)',
        4 => '4 (Above average)',
        5 => '5 (Excellent)',
    ];

    /**
    * Enum - review status
    */
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DENIED = 2;
    const STATUS_RESPONDED = 3;
    const STATUS_IGNORED = 4;
    public static $statuses = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_DENIED => 'Denied',
        self::STATUS_RESPONDED => 'Responded',
        self::STATUS_IGNORED => 'Ignored',
    ];
    public $searchStatuses = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Published',
        self::STATUS_RESPONDED => 'Responded',
        self::STATUS_IGNORED => 'Ignored',
    ];
    public $editStatuses = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Published',
        self::STATUS_DENIED => 'Published Negative',
        self::STATUS_RESPONDED => 'Responded',
        self::STATUS_IGNORED => 'Ignored',
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<bool>
     */
    protected $_accessible = [
        '*' => true,    // TO-DO: THIS IS VERY PERMISSIVE WHILE WE WORK ON FEATURES
        // 'location_id' => true,
        // 'body' => true,
        // 'first_name' => true,
        // 'last_name' => true,
        // 'zip' => true,
        // 'rating' => true,
        // 'is_spam' => true,
        // 'status' => true,
        // 'origin' => true,
        // 'response' => true,
        // 'response_status' => true,
        // 'created' => true,
        // 'modified' => true,
        // 'denied_date' => true,
        // 'ip' => true,
        // 'character_count' => true,
        // 'location' => true,
    ];
}
