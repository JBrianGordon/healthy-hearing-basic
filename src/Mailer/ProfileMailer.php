<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * Profile mailer.
 */
class ProfileMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'Profile';

    public function clinicDefaultEmail($location)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($location['email'])
            ->setSubject('Profile Created')
            ->setViewVars([
                'clinicTitle' => $location['title'],
                'clinicAddress' => $location['address'],
            ])
            ->viewBuilder()
                ->setTemplate('Profile/clinic_default_email');
    }

    public function profileUpdate($location)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($location['email'])
            ->setSubject('Profile Updated')
            ->setViewVars([
                'clinicTitle' => $location['title'],
                'url' => $location['url']
            ])
            ->viewBuilder()
                ->setTemplate('Profile/profile_update');
    }

    /*** TODO: I think LocationUsers controller needs to be built out for this action */
    public function resetPasswordEmail($requestData)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($requestData['email'])
            ->setSubject('Reset Password')
            ->setViewVars([
                'name' => $requestData['first_name'],
                'email' => $requestData['email']
            ])
            ->viewBuilder()
                ->setTemplate('Profile/reset_password_email');
    }

    public function upgradeProfile($location)
    {
        $this
            ->setEmailFormat('html')
            ->setTo($location['email'])
            ->setSubject('Upgrade Profile')
            ->setViewVars([
                'clinicTitle' => $location['title'],
                'url' => $location['url']
            ])
            ->viewBuilder()
                ->setTemplate('Profile/upgrade_profile');
    }
}