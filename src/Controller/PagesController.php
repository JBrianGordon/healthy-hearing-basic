<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 * @method \App\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PagesController extends AppController
{
    /**
     * Homepage
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function home()
    {
        $content = $this->Pages->findByTitle('home')->first()->content;
        $this->set('content', $content);
    }

    /**
     * View method
     *
     * @param string|null $page Page title.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($page = null)
    {
        $page = $this->Pages->findByTitle($page)->first();
        $this->set(compact('page'));
    }
}
