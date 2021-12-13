<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CountMetrics Controller
 *
 * @property \App\Model\Table\CountMetricsTable $CountMetrics
 * @method \App\Model\Entity\CountMetric[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CountMetricsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $countMetrics = $this->paginate($this->CountMetrics);

        $this->set(compact('countMetrics'));
    }

    /**
     * View method
     *
     * @param string|null $id Count Metric id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $countMetric = $this->CountMetrics->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('countMetric'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $countMetric = $this->CountMetrics->newEmptyEntity();
        if ($this->request->is('post')) {
            $countMetric = $this->CountMetrics->patchEntity($countMetric, $this->request->getData());
            if ($this->CountMetrics->save($countMetric)) {
                $this->Flash->success(__('The count metric has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The count metric could not be saved. Please, try again.'));
        }
        $this->set(compact('countMetric'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Count Metric id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $countMetric = $this->CountMetrics->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $countMetric = $this->CountMetrics->patchEntity($countMetric, $this->request->getData());
            if ($this->CountMetrics->save($countMetric)) {
                $this->Flash->success(__('The count metric has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The count metric could not be saved. Please, try again.'));
        }
        $this->set(compact('countMetric'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Count Metric id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $countMetric = $this->CountMetrics->get($id);
        if ($this->CountMetrics->delete($countMetric)) {
            $this->Flash->success(__('The count metric has been deleted.'));
        } else {
            $this->Flash->error(__('The count metric could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
