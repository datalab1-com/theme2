<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;
use Cake\ORM\TableRegistry;

/**
 * Kbase Controller
 *
 * @property \App\Model\Table\KbaseTable $Kbase
 */
class KbaseController extends AppController
{
    public function review($cat = null, $debug = false)
    {
		$this->load($cat, 'dev', 'qna', false);

		if ($debug === 'debug')
			$this->set('showDebug', $debug);
    }

    public function qna($cat = null)
    {	
		$this->load($cat, 'dev', 'qna');
	}	 
	
    public function faq($cat = null)
    {		
		$this->load($cat, 'faq', 'faq');
		
		$this->render('qna');
	}	 
	 
    public function load($cat, $catParent, $catUrl, $paginate = true)
    {
		//
		// get categories for side menu
		//
		$categories = TableRegistry::get('Categories');
		
		if (!isset($catParent))
			$catParent = 'dev';

		$query = $categories
			->find()
			->contain(['ParentCategories'])
			->where(['ParentCategories.nickname = ' => $catParent])
			->order(['Categories.name' => 'ASC'])
		;
		
		$query->select(['total_questions' => $query->func()->count('Kbase.id')])
			->leftJoinWith('Kbase')
			->group(['Categories.id'])
			->autoFields(true);		
		
		// if category not set, find the first category with questions and show it
		if (!isset($cat))
		{
			foreach($query as $rec)
			{
				//debug($rec->total_questions);
				if (intval($rec->total_questions) > 0)
				{
					$cat = $rec->nickname;
					break;
				}
			}
		}		
		
		$this->set('categories', $query);
		
		//dump($query);die;

		//
		// load first topic
		//	

		$title = null;
		
		if ($cat != null)
		{
			if ($cat == 'faq')
			{
				$title = "Frequently Asked Questions";
			}
			else if ($cat == 'kb')
			{
				$title = "Knowledgebase";
			}
			else
			{
				// title set in the view
			}
		}
		
		//
		// get the kbase questions
		//
		if ($paginate)
		{
			$this->paginate = [
				'contain' => ['Users'],
				'order' => [
					'Kbase._order' => 'asc'
				]
			];
			
			$query = $this->Kbase->find()
				->contain(['Categories'])
				->where(['Categories.nickname =' => $cat])
				;

			$this->set('records', $this->paginate($query));
		}
		else
		{
			$query = $this->Kbase->find()
				->contain(['Categories'])
				->where(['Categories.nickname =' => $cat])
				->all()
				;
				
			$this->set('records', $query);
		}

		$this->set('allowReview', $paginate);
		$this->set('questionCount', $query->count());
		$this->set('questionPrompt', $query->first()['category']['description']);
		$this->set('categoryId', $query->first()['category']['id']);
        $this->set('_serialize', ['kbase']);
		$this->set('title', $title);
        $this->set('activeCategory', $cat);
        $this->set('activeUrl', $catUrl);
    }
		
	public function beforeFilter(\Cake\Event\Event $event)
    {
		$this->nonAdminActions = array('index', 'qna', 'faq', 'review');
						
		// localhost/kbase/qna

		parent::beforeFilter($event);
		
		$this->Auth->allow(['index', 'qna', 'faq']);

		if (in_array($this->request->params['action'], $this->nonAdminActions))
		{
			$this->viewBuilder()->layout('default');
		}
		else
		{
			$this->viewBuilder()->layout('admin');
		}		
	}

    /**
     * List method - for the logged in list
     *
     * @return void
     */
    public function admin($cat = null)
    {	
		//
		// get categories for side menu
		//
		$categories = TableRegistry::get('Categories');
			
		$query = $categories
			->find('all')
			->contain(['ParentCategories'])
			->order(['Categories.name' => 'ASC'])
		;
		
		$this->set('categories', $query);
		
		//dump($query);
	
		//
		// get specified kbase records
		//
		$title = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : 'Kbase';
		$this->set('title', $title);

        $this->paginate = [
            'contain' => ['Users'],
			'order' => [
				//'Kbase.category' => 'asc',
				'Kbase._order' => 'asc'
			]			
        ];

		if (isset($cat) && $cat != "")
			$query = $this->Kbase->find()->contain(['Categories'])->where(['Categories.nickname =' => $cat]);
		else
			$query = $this->Kbase->find()->contain(['Categories'])->order(['Categories.name' => 'ASC']);
			
        $this->set('kbase', $this->paginate($query));
        $this->set('_serialize', ['kbase']);
    }
	
    /**
     * group method - for the logged in list
     *
     * @return void
     */
    public function group($cat, $subcat = null)
    {	
		//
		// get categories for side menu
		//
		$categories = TableRegistry::get('Categories');
			
		$query = $categories
			->find()
			->contain(['ParentCategories'])
			->where(['ParentCategories.nickname = ' => $cat])
			->order(['Categories.name' => 'ASC'])
		;
		
		$this->set('categories', $query);
		
		//dump($query);
	
		//
		// get specified kbase records
		//
		$title = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : $cat;
		$this->set('title', $title);

        $this->paginate = [
            'contain' => ['Users'],
			'order' => [
				//'Kbase.category' => 'asc',
				'Kbase._order' => 'asc'
			]			
        ];

		if (isset($cat) && $cat != "")
			$query = $this->Kbase->find()->contain(['Categories'])->where(['Categories.nickname =' => $cat]);
		else
			$query = $this->Kbase->find()->contain(['Categories'])->order(['Categories.name' => 'ASC']);
			
        $this->set('kbase', $this->paginate($query));
        $this->set('_serialize', ['kbase']);
    }	
	
    /**
     * Index method
     *
     * @return void
     */
    public function index($cat = null)
    {
		$this->paginate = [
            'contain' => ['Users'],
			'order' => [
				'Kbase._order' => 'asc'
			]
		];
	
		$title = "Kbase";
		
		if ($cat != null)
		{
			if ($cat == 'faq')
			{
				$title = "Frequently Asked Questions";
			}
			else if ($cat == 'kb')
			{
				$title = "Knowledgebase";
			}
			else
			{
				$title = $cat;
			}
		}
		else
		{
			$cat = "dev";
		}
		
		$query = $this->Kbase->find()
			->contain(['Categories'])
			->where(['Categories.nickname =' => $cat]);
			
        $this->set('records', $this->paginate($query));
        $this->set('_serialize', ['kbase']);
		$this->set('title', $title);
    }

    /**
     * View method
     *
     * @param string|null $id Kbase id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kbase = $this->Kbase->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('kbase', $kbase);
        $this->set('_serialize', ['kbase']);
        $this->set('showEdit', true);		
        $this->set('showDelete', true);		
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($categoryId = null)
    {
        $kbase = $this->Kbase->newEntity();
		
        if ($this->request->is('post')) 
		{
            $kbase = $this->Kbase->patchEntity($kbase, $this->request->data);
			
            if ($this->Kbase->save($kbase)) 
			{
                $this->Flash->success(__('The Question has been saved.'));
				
				return $this->redirect(['action' => 'admin']);
            } 
			else 
			{
                $this->Flash->error(__('The Question could not be saved. Please, try again.'));
            }
        }
		
		$this->set('categoryId', $categoryId);
		
        $users = $this->Kbase->Users->find('list', ['limit' => 200]);
        $categories = $this->Kbase->Categories->find('list');
        $this->set(compact('kbase', 'users', 'categories'));
        $this->set('_serialize', ['kbase']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Kbase id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kbase = $this->Kbase->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kbase = $this->Kbase->patchEntity($kbase, $this->request->data);
            if ($this->Kbase->save($kbase)) 
			{
                $this->Flash->success(__('The kbase has been saved.'));
                //pre-category: return $this->redirect(['action' => 'admin', $this->request->data['category']]);
                return $this->redirect(['action' => 'admin']);
            } 
			else 
			{
                $this->Flash->error(__('The kbase could not be saved. Please, try again.'));
            }
        }
		
        $users = $this->Kbase->Users->find('list', ['limit' => 200]);
        $categories = $this->Kbase->Categories->find('list');
        $this->set(compact('kbase', 'users', 'categories'));
		
        $this->set('_serialize', ['kbase']);
		
        $this->set('showDelete', true);		
    }

    /**
     * Delete method
     *
     * @param string|null $id Kbase id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kbase = $this->Kbase->get($id);
        if ($this->Kbase->delete($kbase)) {
            $this->Flash->success(__('The kbase has been deleted.'));
        } else {
            $this->Flash->error(__('The kbase could not be deleted. Please, try again.'));
        }
		
        return $this->redirect(['action' => 'admin']);
    }
}
