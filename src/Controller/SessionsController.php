<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Sessions Controller
 *
 * @property \App\Model\Table\SessionsTable $Sessions
 */
class SessionsController extends AppController
{
    /**
     * Show method - shows current session or form to start new session
     *
     * @return void
     */
    public function start($dayOffset = 0)
    {
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
		
		$this->indexToday($dayOffset);
	}
	
    /**
     * Index method
     *
     * @return void
     */
    public function indexToday($dayOffset = 0)
    {		
		$dayStart = null;
		$dayEnd = null;
		$this->getDay($dayOffset, $dayStart, $dayEnd, "America/Chicago");
		
		$query = $this->Sessions->find()
			->where(['Sessions.created >=' => $dayStart])
				->where(['Sessions.created <=' => $dayEnd])
            ->contain(['Users', 'Projects', 'Tasks'])
			->order(['Sessions.created' => 'DESC'])
			;
			
		// this is just total elapsed time for the day not a real datetime
		$totalTime = new Time('2000-01-01');
		//debug($totalTime);
		
		$recs = $query->toArray();
		//debug($recs);die;
		
		$index = 0;
		foreach ($recs as $session)
		{		
			$start = new Time($session['created']);
			$stop = new Time($session['stopped']);
			$interval = $start->diff($stop);
			$totalTime->add($interval);
			
			// if elapsed time is more than 0 days, show the day part too
			if ($interval->days > 0)
				$timeLapse = $interval->format('%D:%H:%I'); // show DD:MM:SS
			else
				$timeLapse = $interval->format('%H:%I');	// just show MM:SS

			/* show state */
			if ($session->state == 0) 
				$state = "not started";
			else if ($session->state == 1) 
				$state = "<span style='font-weight: normal;'>STARTED</span>";
			else if ($session->state == 2) 
				$state = "stopped";
			else
				$state = "invalid";	
				
			$recs[$index]['timeLapse'] = $timeLapse;
			$recs[$index]['totalTime'] = $totalTime->format('H:i');
			$recs[$index]['stateDesc'] = $state;
			
			$index++;
		}			

				
        $this->set('sessions', $recs);
        $this->set('totalTime', $totalTime);
		//debug($sessions);die;

        $this->set('_serialize', ['sessions']);
    }

   /**
     * Index method
     *
     * @return void
     */
    public function index($dayOffset = null)
    {
		if ($dayOffset != null)
		{
			$this->indexToday($dayOffset);
		}
		else
		{
			$this->indexToday();
			
			/* need pagination? 
			$this->paginate = [
				'contain' => ['Users', 'Projects', 'Tasks'],
				'order' => ['created' => 'DESC']
			];
			
			$this->set('sessions', $this->paginate($this->Sessions));
			$this->set('_serialize', ['sessions']);
			*/
		}
    }
	
    /**
     * View method
     *
     * @param string|null $id Session id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $session = $this->Sessions->get($id, [
            'contain' => ['Users', 'Projects', 'Tasks']
        ]);
        $this->set('session', $session);
        $this->set('_serialize', ['session']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		// if add comes from projects, then user_id isn't set
		if (!in_array('user_id', $this->request->data))
		{
			$userId = $this->Auth->user()['id'];
			$this->request->data['user_id'] = $userId;
			//dump($this->request->data);die;
		}
		
		$this->request->data['state'] = 1;
			
        $session = $this->Sessions->newEntity();
		
        if ($this->request->is('post')) {
            $session = $this->Sessions->patchEntity($session, $this->request->data);
            if ($this->Sessions->save($session)) {
                $this->Flash->success(__('New Session has started'));
                return $this->redirect(['controller' => 'sessions', 'action' => 'start']);
            } else {
                $this->Flash->error(__('The session could not be started. Please, try again.'));
            }
        }
        $users = $this->Sessions->Users->find('list', ['limit' => 200]);
        $projects = $this->Sessions->Projects->find('list', ['limit' => 200]);
        $tasks = $this->Sessions->Tasks->find('list', ['limit' => 200]);
        $this->set(compact('session', 'users', 'projects', 'tasks'));
        $this->set('_serialize', ['session']);
    }
	
    /**
     * Edit method
     *
     * @param string|null $id Session id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {		
		// if sessionId is set then it's coming from the first STOP SESSION form in projects
		if (isset($this->request->data['sessionId']))
		{
			$id = $this->request->data['sessionId'];
			$post = false;
		}
		else
		{
			$post = true;
		}
		
		// set the session state to STOPPED
		$this->request->data['state'] = 2;
	
        $session = $this->Sessions->get($id, [
            'contain' => []
        ]);
				
		//debug($session['created']);die;
		
        if ($post && $this->request->is(['patch', 'post', 'put'])) 
		{
            $session = $this->Sessions->patchEntity($session, $this->request->data);

			// change the timezone back to UTC after displaying it in local timezone
			$session->created = $this->fixTimeZone($this->request->data['created'], "America/Chicago", "UTC");				
			$session->stopped = $this->fixTimeZone($this->request->data['stopped'], "America/Chicago", "UTC");			
						
            if ($this->Sessions->save($session)) {
                $this->Flash->success(__('The session has been updated.'));
                return $this->redirect(['action' => 'start']);
            } else {
                $this->Flash->error(__('The session could not be updated. Please, try again.'));
            }
        }
		else
		{
			if (!isset($session->stopped))
				$session->stopped = Time::now();
			
			$session->created->timezone = "America/Chicago";
			$session->stopped->timezone = "America/Chicago";
		}

        $users = $this->Sessions->Users->find('list', ['limit' => 200]);
        $projects = $this->Sessions->Projects->find('list', ['limit' => 200]);
        $tasks = $this->Sessions->Tasks->find('list', ['limit' => 200]);
        $this->set(compact('session', 'users', 'projects', 'tasks'));
        $this->set('_serialize', ['session']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Session id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $redirect = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $session = $this->Sessions->get($id);
        if ($this->Sessions->delete($session)) {
            $this->Flash->success(__('The session has been deleted.'));
        } else {
            $this->Flash->error(__('The session could not be deleted. Please, try again.'));
        }
		
		if ($redirect)		
			return $this->redirect(['action' => $redirect]);
		else
			return $this->redirect(['action' => 'start']);
    }
}
