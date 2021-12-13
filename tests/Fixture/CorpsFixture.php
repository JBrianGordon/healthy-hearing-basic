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
                'type' => 'Lorem ipsum do',
                'created' => '2021-12-10 21:23:59',
                'modified' => '2021-12-10 21:23:59',
                'last_modified' => '2021-12-10 21:23:59',
                'modified_by' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'title_long' => 'Lorem ipsum dolor sit amet',
                'slug' => 'Lorem ipsum dolor sit amet',
                'abbr' => 'L',
                'short' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'notify_email' => 'Lorem ipsum dolor sit amet',
                'approval_email' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum dolor sit amet',
                'website_url' => 'Lorem ipsum dolor sit amet',
                'website_url_description' => 'Lorem ipsum dolor sit amet',
                'pdf_all_url' => 'Lorem ipsum dolor sit amet',
                'favicon' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet',
                'thumb_url' => 'Lorem ipsum dolor sit amet',
                'facebook_title' => 'Lorem ipsum dolor sit amet',
                'facebook_description' => 'Lorem ipsum dolor sit amet',
                'facebook_image' => 'Lorem ipsum dolor sit amet',
                'date_approved' => '2021-12-10 21:23:59',
                'id_old' => 1,
                'is_approvalrequired' => 1,
                'is_active' => 1,
                'is_featured' => 1,
                'id_draft_parent' => 1,
                'wbc_config' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'order' => 1,
            ],
        ];
        parent::init();
    }
}
