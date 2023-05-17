<?php
declare(strict_types=1);

namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Http\Session;
use DateTime;

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

        $session = new Session();
        $sessionData = $session->read();
        $loginIp = $session->read('loginIp');

        // Redirect to role-based panel
        if ($user->role === 'admin') {
            $event->setResult([
                'plugin' => false,
                'prefix' => 'Admin',
                'controller' => 'Utils',
                'action' => 'panel',
            ]);
        } elseif ($user->role === 'clinic') {
            // Record IP of clinic after login
            $loginIpsTable = $this->fetchTable('LoginIps');
            $userLoginIpEntity = $loginIpsTable->newEntity(
                [
                    'user_id' => $user->id,
                    'ip' => $loginIp,
                    'login_date' => new DateTime('now'),
                ],
                ['validate' => false],
            );
            $loginIpsTable->save($userLoginIpEntity);

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
