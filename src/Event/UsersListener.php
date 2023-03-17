<?php

namespace App\Event;

use Cake\Cache\Cache;
use Cake\Event\EventListenerInterface;

class UsersListener implements EventListenerInterface
{
    /**
     * @return string[]
     */
    public function implementedEvents(): array
    {
        return [
            \CakeDC\Users\Plugin::EVENT_AFTER_LOGIN => 'afterLogin',
        ];
    }

    /**
     * @param \Cake\Event\Event $event
     */
    public function afterLogin(\Cake\Event\Event $event)
    {
        $user = $event->getData('user');
        $controller = $event->getSubject();

        if ($user->role === 'admin') {
            $event->setResult([
                'plugin' => false,
                'prefix' => 'Admin',
                'controller' => 'Utils',
                'action' => 'panel'
            ]);
        } elseif ($user->role === 'clinic') {
            $event->setResult([
                'plugin' => false,
                'prefix' => 'Clinic',
                'controller' => 'Locations',
                'action' => 'edit',
                $user->location_id
            ]);
        }

    }
}