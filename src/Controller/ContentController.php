<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Content Controller
 *
 * @property \App\Model\Table\ContentTable $Content
 * @method \App\Model\Entity\Content[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContentController extends AppController
{
    public $paginate = [
        'limit' => 15,
        'order' => [
            'Content.modified' => 'DESC',
        ],
        'fields' => [
            'Content.title',
            'Content.slug',
            'Content.short',
            'Content.date',
            'Content.created',
            'Content.modified',
            'Content.last_modified',
            'Content.id',
            'Content.type',
            'Content.is_active',
        ],
    ];

    /**
     * ReportIndex method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @todo Create custom finder for is_active and published articles
     */
    public function reportIndex()
    {
        $reports = $this->Content
            ->find('all')
            ->where(['is_active' => 1]);
        $this->set('reports', $this->paginate($reports));
    }

    /**
     * View method
     *
     * @param int|null $id Content id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?int $id = null)
    {
        $content = $this->Content->get($id, [
            'contain' => ['Users', 'Locations', 'Tags'],
        ]);

        $this->set(compact('content'));
    }
}
