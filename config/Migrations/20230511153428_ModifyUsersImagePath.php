<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Cake\ORM\TableRegistry;

class ModifyUsersImagePath extends AbstractMigration
{
    public function up()
    {
        // User images have moved from '/images/' to '/img/about/'. Update the stored url.
        $this->Users = TableRegistry::get('Users');
        $users = $this->Users->find('all', [
            'conditions' => [
                'image_url LIKE' => '/images/%',
            ]
        ])->all();
        foreach ($users as $user) {
            $user->image_url = str_replace('/images/', '/img/about/', $user->image_url);
            $this->Users->save($user);
        }
    }

    public function down()
    {
    }
}
