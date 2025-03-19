<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CorpsFixture
 */
class CorpsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'created' => '2021-12-10 21:23:59',
                'modified' => '2021-12-10 21:23:59',
                'last_modified' => '2021-12-10 21:23:59',
                'modified_by' => 1,
                'title' => 'Corp 1',
                'slug' => 'first-corp-slug',
                'short' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'thumb_url' => 'Lorem ipsum dolor sit amet',
                'facebook_title' => 'Lorem ipsum dolor sit amet',
                'facebook_description' => 'Lorem ipsum dolor sit amet',
                'facebook_image' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'id_draft_parent' => 0,
                'priority' => 1,
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'created' => '2021-12-10 21:23:59',
                'modified' => '2021-12-10 21:23:59',
                'last_modified' => '2021-12-10 21:23:59',
                'modified_by' => 1,
                'title' => 'Corp 2',
                'slug' => 'second-corp-slug',
                'short' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'thumb_url' => 'Lorem ipsum dolor sit amet',
                'facebook_title' => 'Lorem ipsum dolor sit amet',
                'facebook_description' => 'Lorem ipsum dolor sit amet',
                'facebook_image' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'id_draft_parent' => 0,
                'priority' => 2,
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'created' => '2021-12-10 21:23:59',
                'modified' => '2021-12-10 21:23:59',
                'last_modified' => '2021-12-10 21:23:59',
                'modified_by' => 1,
                'title' => 'Corp 3',
                'slug' => 'third-corp-slug',
                'short' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'thumb_url' => 'Lorem ipsum dolor sit amet',
                'facebook_title' => 'Lorem ipsum dolor sit amet',
                'facebook_description' => 'Lorem ipsum dolor sit amet',
                'facebook_image' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'id_draft_parent' => 0,
                'priority' => 3,
            ],
            [ // Draft item - publishable
                'id' => 4,
                'user_id' => 1,
                'created' => '2021-12-10 21:23:59',
                'modified' => '2021-12-10 21:23:59',
                'last_modified' => '2022-03-03 13:14:14',
                'modified_by' => 1,
                'title' => 'Corp 1 - DRAFT',
                'slug' => 'fourth-corp-slug',
                'short' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'thumb_url' => 'Lorem ipsum dolor sit amet',
                'facebook_title' => 'Lorem ipsum dolor sit amet',
                'facebook_description' => 'Lorem ipsum dolor sit amet',
                'facebook_image' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'id_draft_parent' => 1,
                'priority' => 1,
            ],
            [ // Draft item - non-validating
                'id' => 5,
                'user_id' => 1,
                'created' => '2021-12-10 21:23:59',
                'modified' => '2021-12-10 21:23:59',
                'last_modified' => '2021-12-10 21:23:59',
                'modified_by' => 1,
                'title' => '',
                'slug' => 'fifth-corp-slug',
                'short' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'thumb_url' => 'Lorem ipsum dolor sit amet',
                'facebook_title' => 'Lorem ipsum dolor sit amet',
                'facebook_description' => 'Lorem ipsum dolor sit amet',
                'facebook_image' => 'Lorem ipsum dolor sit amet',
                'is_active' => 0,
                'id_draft_parent' => 2,
                'priority' => 2,
            ],        
        ];
        parent::init();
    }
}
