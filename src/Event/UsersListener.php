<?php
declare(strict_types=1);

namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\ORM\Locator\LocatorAwareTrait;

class UsersListener implements EventListenerInterface
{
    use LocatorAwareTrait;

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
     * @param \Cake\Event\Event $event CakePHP Event
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
                'action' => 'panel',
            ]);
        } elseif ($user->role === 'clinic') {
            $locationsUsersForClinic = $this->fetchTable('LocationsUsers')
                ->find()
                ->where(['user_id' => $user->id])
                ->first();
            $event->setResult([
                'plugin' => false,
                'prefix' => 'Clinic',
                'controller' => 'Locations',
                'action' => 'edit',
                $locationsUsersForClinic->location_id,
            ]);
        }
    }
}
