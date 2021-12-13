<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * QueueTaskLogsFixture
 */
class QueueTaskLogsFixture extends TestFixture
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
                'id' => '740faa5a-4b2c-4e83-b51b-a56dd5732f1d',
                'user_id' => 1,
                'created' => '2021-12-10 21:24:11',
                'modified' => '2021-12-10 21:24:11',
                'executed' => '2021-12-10 21:24:11',
                'scheduled' => '2021-12-10 21:24:11',
                'scheduled_end' => '2021-12-10 21:24:11',
                'reschedule' => 'Lorem ipsum dolor sit amet',
                'start_time' => 1,
                'end_time' => 1,
                'cpu_limit' => 1,
                'is_restricted' => 1,
                'priority' => 1,
                'status' => 1,
                'type' => 1,
                'command' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'result' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}
