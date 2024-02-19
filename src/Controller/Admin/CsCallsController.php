<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * CsCalls Controller
 *
 * @property \App\Model\Table\CsCallsTable $CsCalls
 * @method \App\Model\Entity\CsCall[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CsCallsController extends BaseAdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $csCalls = $this->paginate($this->CsCalls);

        $this->set(compact('csCalls'));
    }
}
