<?php
declare(strict_types=1);

namespace App\Controller\Clinic;

use App\Controller\AppController;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 * @method \App\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PagesController extends BaseClinicController
{

    /**
     * Clinic FAQ page
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function clinicFaq() {
        $page = $this->Pages->findByTitle('clinicFaq')->first();
        $this->viewBuilder()->setLayout('clinic_panel');
        $this->set(compact('page'));
        $this->set('show_slider', false);
    }
}
