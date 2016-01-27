<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;

/**
 * Contacts Controller
 *
 * @property \App\Model\Table\ContactsTable $Contacts
 */
class ContactsController extends AppController
{
    /**
     * beforeFilter method
     *
     * @return void
     */
	public function beforeFilter(\Cake\Event\Event $event)
	{	
		parent::beforeFilter($event);
		
		$this->Auth->allow(['add']);
		
		$this->viewBuilder()->layout('admin');		
	}

    /**
     * List method - for the logged in list
     *
     * @return void
     */
    public function indexAdmin()
    {
        $this->index();
    }
	
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('contacts', $this->paginate($this->Contacts));
        $this->set('_serialize', ['contacts']);
    }

    /**
     * View method
     *
     * @param string|null $id Contact id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => []
        ]);
        $this->set('contact', $contact);
        $this->set('_serialize', ['contact']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($src = null)
    {
		$this->viewBuilder()->layout('default');
		
        $contact = $this->Contacts->newEntity();
		
        if ($this->request->is('post')) 
		{	
			// save it if at least the email address is set
			if (isset($this->request->data['email']) && trim($this->request->data['email']) != "")
			{
				if (!isset($this->request->data['name']) || trim($this->request->data['name']) == "")
				{
					$this->request->data['name'] = '(no name)';
				}
				if (!isset($this->request->data['message']) || trim($this->request->data['message']) == "")
				{
					$this->request->data['message'] = '(no message)';
				}
				
				$contact = $this->Contacts->patchEntity($contact, $this->request->data);
	
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: ' . $contact['email'] . "\r\n";
				
				mail('sbwilkinson1@gmail.com', 'devspace contact message from ' . $contact['name'], $contact['message'], 'From: ' . $contact['email']);
				//mail('info@devspace.co', 'devspace contact message from ' . $contact['name'], $contact['email'] . ': ' . $contact['message'], $headers);
				
				if ($this->Contacts->save($contact)) 
				{
					$this->Flash->success(__('Your message has been sent.'));
										
					if ($src == "fp")
					{
						return $this->redirect('/#why-choose');
					}
					else
					{
						return $this->redirect(['action' => 'add']);
					}
				} 
				else 
				{
					$this->Flash->error(__('The message could not be sent. Please, try again.'));
				}			
			}
			else
			{
                $this->Flash->error(__('Email address is required. Please, try again.'));
			}
			
			//Debugger::dump($this->request->data);die;
        }
		
        $this->set(compact('contact'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contact id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contact = $this->Contacts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contact = $this->Contacts->patchEntity($contact, $this->request->data);
            if ($this->Contacts->save($contact)) {
                $this->Flash->success(__('The contact has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The contact could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('contact'));
        $this->set('_serialize', ['contact']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contact = $this->Contacts->get($id);
        if ($this->Contacts->delete($contact)) {
            $this->Flash->success(__('The contact has been deleted.'));
        } else {
            $this->Flash->error(__('The contact could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
