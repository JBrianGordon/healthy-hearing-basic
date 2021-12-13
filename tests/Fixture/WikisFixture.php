<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WikisFixture
 */
class WikisFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'slug' => 'Lorem ipsum dolor sit amet',
                'user_id' => 1,
                'consumer_guide_id' => 'Lorem ipsum dolor sit amet',
                'responsive_body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'short' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_active' => 1,
                'id_draft_parent' => 1,
                'order' => 1,
                'title_head' => 'Lorem ipsum dolor sit amet',
                'title_h1' => 'Lorem ipsum dolor sit amet',
                'background_file' => 'Lorem ipsum dolor sit amet',
                'meta_description' => 'Lorem ipsum dolor sit amet',
                'facebook_title' => 'Lorem ipsum dolor sit amet',
                'facebook_image' => 'Lorem ipsum dolor sit amet',
                'facebook_image_bypass' => 1,
                'facebook_image_width' => 1,
                'facebook_image_height' => 1,
                'facebook_image_alt' => 'Lorem ipsum dolor sit amet',
                'facebook_description' => 'Lorem ipsum dolor sit amet',
                'last_modified' => '2021-12-10 21:24:20',
                'modified' => '2021-12-10 21:24:20',
                'created' => '2021-12-10 21:24:20',
                'background_alt' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
