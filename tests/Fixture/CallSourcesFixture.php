<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CallSourcesFixture
 */
class CallSourcesFixture extends TestFixture
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
                'customer_name' => 'Lorem ipsum dolor sit amet',
                'location_id' => 1,
                'is_active' => 1,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'phone_number' => 'Lorem ipsum dolor sit a',
                'target_number' => 'Lorem ipsum dolor sit a',
                'clinic_number' => 'Lorem ipsum dolor sit a',
                'start_date' => 'Lorem ipsum dolor ',
                'end_date' => 'Lorem ipsum dolor ',
                'created' => '2021-12-10 21:23:55',
                'is_ivr_enabled' => 1,
            ],
        ];
        parent::init();
    }
}
