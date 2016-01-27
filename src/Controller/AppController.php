<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	protected $nonAdminActions = array(); // set template for normal or admin functions
	protected $isLoggedIn = false;
	protected $userName = null;
	
    public $helpers = array('Custom');		
	
	public function isLoggedIn() {	
		return $this->Auth->user();
	}

	private $userlayout = false;
	public function getUserLayout() {
		return $this->userlayout;
	}
		
    /**
     * checkLogin method
     *
     * @return bool for logged in or not
     */
	public function checkLogin()
	{
		$userName = false;
		$isLoggedIn = $this->isLoggedIn();
		
		if ($isLoggedIn)
		{
			$userName = $this->Auth->user()['email'];
			
			//Debugger::dump($userName);
		}
		
		$this->set('isLoggedIn', $isLoggedIn);
		$this->set('userName', $userName);
		
		return $isLoggedIn;
	}
	
    /**
     * beforeFilter method
     *
     * @return void
     */
	public function beforeFilter(\Cake\Event\Event $event)
	{	
		// check if user is logged in
		$this->checkLogin();

		$this->set('urlKbase', '/kbase/index/kb');
		$this->set('urlFaq', '/kbase/index/faq');
		$this->set('urlContact', '/contacts/add');
		$this->userlayout = 'default';
		
		if (in_array($this->request->params['action'], $this->nonAdminActions))
		{
			$this->viewBuilder()->layout('default');
		}
		else
		{
			$this->viewBuilder()->layout('admin');
		}
		
		//
		// get the data tha goes in to layout
		//
		$kbaseTable = null;
		$sessionsTable = null;
		
		try {
		
			$kbaseTable = TableRegistry::get('Kbase');
			$sessionsTable = TableRegistry::get('Sessions');
		
		} catch(Exception $e) {
		
			// this isn't catching the cake exception
		
		} finally {
		
		
		}
			
		//
		// load up kbase data used for website content cms
		//
		$query = null;
		if($kbaseTable != null) 
		{
			$query = $kbaseTable
				->find('all')
				->contain(['Categories'])
				->order(['Categories.name' => 'DESC', '_order' => 'ASC'])
			;
		}
		$this->set('kbase', $query);
		
		//dump($query);
		//Debugger::dump($query); die;							
		
		//
		// check if a timer session is running to show it in the admin window
		//
		$query = null;
		$rec = null;
		if($sessionsTable != null) 
		{
			$rec = $sessionsTable
				->find()
				->contain(['Projects'])				
				->order(['Sessions.id' => 'DESC'])
				->first()
				;
		}
		
		// timer started?
		if ($rec != null)
		{
			if ($rec['state'] == 1)
			{
				$this->set('startTimer', false); // already started
				$this->set('startTimeUtc', $rec['created']);
				$this->set('startTimeProject', $rec['project']['name']);
			}
			
			$this->set('lastProject', $rec['project_id']);
			$this->set('lastTask', $rec['task_id']);
		}
		else
		{
			$this->set('startTimer', true); // not started
		}
				
		$this->set('site_title', 'Devspace: Technology Services, Design, and Development');
		$this->set('site_author', 'devspace.co');	
		$this->set('debug', ($this->request->env('HTTP_HOST') == 'localhost'));			
	}

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initializeORIG()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }
	
    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
			'authorize'=> 'Controller',//added this line
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);

        // Allow the display action so our pages controller continues to work.
        $this->Auth->allow(['display']);		
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
	
    /**
     * Check if user is authorized to perform an action, turn off all by default
     *
     * @param $usre to check
     * @return bool for is authorized
     */
	public function isAuthorized($user)
	{
		return true;
	}	
	
    /**
     * Get datetime for today starting at 00:00:00
     *
     * @return Time object
     */
	public function getToday(&$start, &$end, $localTimezone = "America/Chicago")
	{
		// get the date/time in local timezone
		$today = new Time("", $localTimezone);
				
		$this->getDayUtc($today->format("Y/m/d"), $start, $end, $localTimezone);
	}
	
	public function getDay($dayOffset, &$start, &$end, $localTimezone = "America/Chicago")
	{
		// get the date/time in local timezone
		$today = new Time("", $localTimezone);

		$today->addDays($dayOffset);
				
		$this->getDayUtc($today->format("Y/m/d"), $start, $end, $localTimezone);
	}
	
    /**
     * Get datetime range for today from at 00:00:00 to 23:59:59
     *
     * @return none
     */
	public function getDayUtc($date, &$start, &$end, $localTimezone)
	{
		// get the date/time in local timezone
		$day = new Time($date, $localTimezone);
		$start = new Time($day->format("Y/m/d"), "America/Chicago"); // peel off the time, leave the date only
		$end = new Time($day->format("Y/m/d 23:59:59"), "America/Chicago");

		// change them to utc for the 
		$start->timezone = "UTC";
		$end->timezone = "UTC";		
		
		//debug($start);
		//debug($end);
		//die;
	}
	
    /**
     * Converts form request fields to a Time object for the specified timezone
     *
     * @return Time object
     */
	public function fixTimeZone($dt, $tzFrom, $tzTo)
    {		
		$time = new Time(sprintf("%d-%.02d-%.02d %.02d:%.02d:00"
			, $dt['year']
			, $dt['month']
			, $dt['day']
			, $dt['hour']
			, $dt['minute']
		), $tzFrom);
		
		$time->timezone = $tzTo;
	
		return $time;
	}	
}
