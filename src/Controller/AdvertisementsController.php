<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Advertisements Controller
 *
 * @property \App\Model\Table\AdvertisementsTable $Advertisements
 * @method \App\Model\Entity\Advertisement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdvertisementsController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id Advertisement id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $advertisement = $this->Advertisements->get($id, [
            'contain' => ['Corps'],
        ]);

        $this->set(compact('advertisement'));
    }
}
