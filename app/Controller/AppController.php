<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array('Auth','Session');
    public $uses = array('User','AppSettings');
    protected $app_id = 0;
    protected $logged_in = false;
    protected $logged_in_details = false;
    
    function beforeFilter() {
//        $this->Auth->authenticate = array(
//			'Form' => array(
//				'userModel' => 'User',
//				'fields' => array('username' => 'us_email', 'password' => 'us_password'),
//                                'loginAction' => array('controller' => 'api', 'action' => 'login')
//			),
//		);
        
        
    }
    protected function _flash($message, $type = 'message') {
            $messages = (array) $this->Session->read('Message.multiFlash');
            $messages[] = array(
                    'message' => '<div class="alert ng-scope am-fade alert-' . $type . '">' . $message . '</div>',
                    'layout' => 'default',
                    'element' => 'default',
                    'params' => array('class' => 'msg'),
            );
            $this->Session->write('Message.multiFlash', $messages);
    }
    function beforeRender(){
        $users = array();
//            $this->set('loggedUser', array());
//            $user_data = $this->User->find("all",array('fields' => array('us_id','us_first_name','us_last_name'),'conditions' => array('us_status'=>'Active')));
//            $users = array();
//            foreach($user_data as $user){
//                $users[$user["User"]["us_id"]] = $user['User']['us_first_name'] .' ' . $user['User']['us_last_name'];
//            }
            
            $this->set('users',$users);
    }
    protected function sendMail($to, $subject, $data, $template, $config = 'noreply', $type = "html", $attachments = array()) {
		App::uses('CakeEmail', 'Network/Email');
		$Email = new CakeEmail();
		$Email->config($config);
		$Email->to($to);
		$Email->subject($subject);
		$Email->template($template); // note no '.ctp'
		$Email->viewVars($data);
		$Email->emailFormat($type); // because we like to send pretty mail
                
//                var_dump($Email);die;
		if (count($attachments) > 0) {
			$Email->addAttachments($attachments);
		}
		try {
			$Email->send();
			$response = $Email->readReceipt();
			$this->set('smtp_error', implode(",", $response));
			if (count($response) > 0) {
				return implode(",", $response);
			} else {
				return true;
			}
		} catch (SocketException $e) {
			$this->set('smtp_error', $e->getMessage());
			return $e->getMessage();
		}
	}
}
