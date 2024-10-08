<?php
//TODO: Delete this before pushing to dev
// src/Mailer/UserMailer.php
namespace App\Mailer;

use Cake\Mailer\Mailer;

class UserMailer extends Mailer
{
    public function welcome($user)
    {
        $this
            ->setTransport('default')
            ->setEmailFormat('html')
            ->setFrom(['no-reply@example.com' => 'My App'])
            ->setTo($user->email)
            ->setSubject('Welcome to our app')
            ->setViewVars(['username' => $user->username])
            ->viewBuilder()
                ->setTemplate('welcome_email');  // By default, this template will be at src/Template/Email/html/welcome_email.php
    }
}
?>
<!-- src/Template/Email/html/welcome_email.php -->
<p>Dear <?= h($username) ?>,</p>
<p>Welcome to our app!</p>
<p>Best regards,</p>
<p>The Team</p>

<?
// In a controller
$mailer = new \App\Mailer\UserMailer();
$mailer->send('welcome', [$user]);

//Expanded controller example

namespace App\Controller;

use App\Controller\AppController;
use App\Mailer\UserMailer;

class UsersController extends AppController
{
    public function register()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->newEntity($this->request->getData());
            if ($this->Users->save($user)) {
                // User registered successfully, send welcome email
                $mailer = new UserMailer();
                $mailer->send('welcome', [$user]);

                $this->Flash->success('You have registered successfully.');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('There was a problem registering your account.');
        }
    }
}
?>