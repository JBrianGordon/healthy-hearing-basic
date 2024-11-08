<?php
declare(strict_types=1);

namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\Cache\Cache;

class CkBoxListener implements EventListenerInterface
{
    public function implementedEvents(): array
    {
        return [
            'CkBoxUtility.afterUploadImage' => 'ckBoxUploadImage',
        ];
    }

    public function ckBoxUploadImage(\Cake\Event\Event $event)
    {
        $eventData = $event->getData();

        $eventId = $eventData['response']['id'];
        $filename = $eventData['response']['name'];

        Cache::write('ckBoxUploadImage_' . $filename, $eventData, 'default');
    }
}