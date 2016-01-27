<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{
	public function beforeFilter(\Cake\Event\Event $event)
    {
		$this->nonAdminActions = array('paypal', 'paypalipn', 'paypalcomplete', 'paypalcancel');
				
		parent::beforeFilter($event);
		
		// localhost/payments/paypalipn		
		$this->Auth->allow(['paypal', 'paypalipn', 'paypalcomplete', 'paypalcancel']);
		//Debugger::dump($this->Auth);die;
	}
	
    /**
     * paypalipn method
     *
     * @return void
     */

	// paypal merchant account
	// Merchant account ID2Z4JNDNDP6W56
    public function paypal()
    {			
		// this shows the paypal button view
	}
	
    public function paypalipn($parms = null)
    {			
		$this->paypaladd(1, 'paypal ipn', $parms);
	}

    public function paypalcomplete($parms = null)
    {
		//Debugger::dump($parms);die;
		
		if ($parms == 'paid')
		{
			$tx = $this->request->query('tx');
			$st = $this->request->query('st');
			$amt = $this->request->query('amt');
			$cc = $this->request->query('cc');
			$cm = $this->request->query('cm');
			$item_number = $this->request->query('item_number');
			
			$parms = 'tx=' . $tx;
			$parms .= '&amt=' . $amt;
			$parms .= '&st=' . $st;
			$parms .= '&cc=' . $cc;
			$parms .= '&cm=' . $cm;
			$parms .= '&item_number=' . $item_number;
			
			//Debugger::dump($parms);die;
		}
		
		// paypal completed link
		// localhost/payments/paypalcomplete/paid?tx=8T174297S3669650M&st=Completed&amt=3.00&cc=USD&cm=&item_number=1
		$this->paypaladd(2, 'paypal button complete', $parms);
	}
	
    public function paypalcancel($parms = null)
    {
		// paypal cancel link:
		// http://devspace.co/payments/cancel	
		$this->paypaladd(3, 'paypal button cancel', $parms);
	}
		
	public function paypaladd($type, $desc, $parms = null)
	{
        $payment = $this->Payments->newEntity([
			'_type' => $type,
			'description' => $desc,
		]);
				
		
		if (isset($parms) && $parms != null)
		{
			$payment->description .= ': ' . $parms;
		}
		
		$msg = null;
		
		if ($this->Payments->save($payment)) 
		{
			$msg = 'Your payment has been completed.';
			
			if ($parms != null)
			{
				$p = explode('&', $parms);
				
				//Debugger::dump(count($p));die;
	
				if (count($p) > 0)
					$msg = 'Your payment has been completed for $' . substr($p[1], strlen('amt='));
			}
			else
			{
			}
		} 
		else 
		{
			$msg = 'Your payment could not be completed. Please, try again.';
		}
		
        $this->set('message', $msg);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
		if ($this->isLoggedIn())
		{
			$this->set('payments', $this->paginate($this->Payments));
			$this->set('_serialize', ['payments']);
		}
		else
		{
			return $this->redirect(['action' => 'paypal']);
		}
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => []
        ]);
        $this->set('payment', $payment);
        $this->set('_serialize', ['payment']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payment = $this->Payments->newEntity();
		
        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->data);
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('payment'));
        $this->set('_serialize', ['payment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->data);
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('payment'));
        $this->set('_serialize', ['payment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
