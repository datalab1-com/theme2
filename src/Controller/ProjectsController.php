<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\SessionsController;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('projects', $this->paginate($this->Projects));
        $this->set('_serialize', ['projects']);	
	}
	
    /**
     * Index method
     *
     * @return void
     */
    public function indexNOTUSED()
    {
		$this->loadModel('Sessions');
		
		//////////////////////////////////////////////////
		// check if a session is in progress
		//////////////////////////////////////////////////
		
		$sessionId = $this->Sessions->getActive();
		$startSession = ($sessionId == 0);
		$this->set('startSession', $startSession);
		
		//////////////////////////////////////////////////
		// show START SESSION form
		//////////////////////////////////////////////////
		
		if ($startSession)
		{
			$session = $this->Sessions->newEntity();
			
			if ($this->request->is('post')) 
			{
				die('start session');
			}
			
			$users = $this->Sessions->Users->find('list', ['limit' => 200]);
			$projectsSession = $this->Sessions->Projects->find('list', ['limit' => 200]);
			$tasks = $this->Sessions->Tasks->find('list', ['limit' => 200]);
			$this->set(compact('session', 'users', 'projectsSession', 'tasks'));
			$this->set('_serialize', ['session']);
		}
		
		//////////////////////////////////////////////////
		// show STOP SESSION form
		//////////////////////////////////////////////////
		
		else if (!$startSession)
		{
			$session = $this->Sessions->get($sessionId, [
				'contain' => ['Projects', 'Tasks']
			]);
			
			//debug($session);die;
			
			if ($this->request->is(['patch', 'post', 'put'])) 
			{
				die('stop session');
			}
			
			$users = $this->Sessions->Users->find('list', ['limit' => 200]);
			$projectsSession = $this->Sessions->Projects->find('list', ['limit' => 200]);
			$tasks = $this->Sessions->Tasks->find('list', ['limit' => 200]);
			$this->set(compact('session', 'users', 'projectsSession', 'tasks'));
			$this->set('_serialize', ['session']);
		}
		
		//////////////////////////////////////////////////
		// original index code
		//////////////////////////////////////////////////
        $this->set('projects', $this->paginate($this->Projects));
        $this->set('_serialize', ['projects']);
    }

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Sessions']
        ]);
        $this->set('project', $project);
        $this->set('_serialize', ['project']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('project'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('project'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
