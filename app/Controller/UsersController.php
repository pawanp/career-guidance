<?php
ob_start();
class UsersController extends AppController {
    
    public $name = 'Users';
    var $Helpers = array('Html','Form','Recaptcha');
  
    public $components = array(
		'Session','Email','Cookie','GeneralFunctions',
		'ReCaptcha' => array(
				'publickey' => '6Ld_JvQSAAAAAAfF5XMEznediRYiNzN5uHlVqSzr',
				'privatekey' => '6Ld_JvQSAAAAAOn-YEzi3-ppQCXHDifwaMWTC_JE'
	    )
    );
    
   /**
    * Function : beforeFilter
    * @access private
    * Description : First function to be run
    */
	
    function beforeFilter(){
        parent::beforeFilter();
	if($this->Auth->user()){
              $this->set('Acive_user',$this->Auth->user());
	}
    }
    
    public function publicProfile($data=null){
	$this->layout='default';
	if($this->Session->check('loginData')){
	    $details = $this->Session->read('loginData');
	    if(isset($details) && !empty($details)){
		pr($details);
		$this->set('details',$details);
	    }
	}
        
    }
    
    
   /**
    * Function : login
    * @access public
    * Description : user's login
    */
    
    public function login() {
    if(!($this->Auth->user())){
	if ($this->request->is('post')) {
		    if ($this->Auth->login()) {
			return $this->redirect($this->Auth->redirectUrl());
			// Prior to 2.3 use
			// `return $this->redirect($this->Auth->redirect());`
		    } else {
			$this->Session->setFlash(__('Username or password is incorrect'),'default',array(),'auth');
		    }
	    }
	}else{
	    $this->redirect(array('controller'=>'users','action'=>'publicProfile'));
	}
    }
    
   /**
    * Function : logout
    * @access public
    * Description : user's logout
    */
    
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
    
   /**
    * Function : register
    * @access public
    * Description : user's login
    */
    
    public function register() {
	if(!($this->Auth->user())){
	    $this->set('recaptcha', $this->ReCaptcha->getReCaptcha());
	    if ($this->request->is('post')) {
		if(isset($_POST["recaptcha_response_field"])) {
		    if($this->ReCaptcha->isReCaptchaValid($_SERVER["REMOTE_ADDR"], $this->request->data["recaptcha_challenge_field"], $this->request->data["recaptcha_response_field"])){
		    $this->User->create();
			if($this->User->save($this->request->data)){
			    $last_user_id = $this->User->getLastInsertId();
			    $registerd_user = $this->User->findById($last_user_id);
			    $activation_link = 'http://' . $_SERVER["HTTP_HOST"] . '/users/account_confirm/' .base64_encode($registerd_user['User']['id'])."/".base64_encode($registerd_user['User']['email']);
			    $this->Session->setFlash("Your account has been createrd! email varification has been sent please check.");
			    $this->send_mail($registerd_user['User']['email'],'Carreradvise@gmail.com',"BOOM! !! Welcome to Career Guidance portal! :) ",$registerd_user['User']['username'],$this->request->data['User']['password'],$activation_link);
			   $this->redirect(array('controller'=>'users','action'=>'login'));
			}else{
			    $this->Session->setFlash("Some problem occured ! please try again");
			}
		    }else{
			$this->Session->setFlash("reCaptcha verification failed");
		    }
		}
	    }
	}else{
	    $this->redirect(array('controller'=>'users','action'=>'publicProfile'));
	}
    }
    
   /**
    * Function : send_email
    * @access public
    * Description : used to send activation link email
    */
    
    function send_mail($to,$from,$subject,$username,$password,$activation_link){
	$this->Email->to = $to;
	$this->Email->from = $from;
	$this->Email->subject = $subject;
	$this->Email->template = 'activation_mail';
	$this->Email->sendAs = "html";
	$this->set(compact('username','password','activation_link'));
	if($this->Email->send()){
	    return 1;
	}else{
	    return 0;
	}
    }
    
   /**
    * Function : register
    * @access public
    * Description : user's login
    */
    
    public function account_confirm($id=null,$email=null) {
	$user_id= base64_decode($id);
	$user_email=base64_decode($email);
	$user_exists = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id,'User.email'=>$user_email)));
	if(isset($user_exists) && !empty($user_exists)){
	    if($this->User->updateAll(array('User.status'=>1),array('User.id'=>$user_exists['User']['id'],'User.email'=>$user_exists['User']['email']))){
		$this->Session->setFlash("Your account has been activated successfully ! please Login to continue.");
		$this->redirect(array('controller'=>'users','action'=>'login'));
	    }else{
		$this->Session->setFlash("Your account has not been activated ! Try agian ");
		$this->redirect(array('controller'=>'users','action'=>'login'));
	    }
	}
    }
    
   /**
    * Function : linkedIn_connect
    * @access public
    * Description : signup/signIn through linkedIn
    */
    
    public function linkedIn_connect(){
	$this->autoRender=false;
	if($this->request->is('post')){
	    $linkedIn_data = $this->request->data['info']['values'][0];
	    $this->Session->write('loginData',$linkedIn_data);
	    $data['User']['linkedIn_id'] = $linkedIn_data['id'];
	    $data['User']['email'] = $linkedIn_data['emailAddress'];
	    $data['User']['firstname'] = $linkedIn_data['firstName'];
	    $data['User']['lastname'] = $linkedIn_data['lastName'];
	    $data['User']['location'] = $linkedIn_data['location']['name'];
	    $data['User']['pictureUrl'] = $linkedIn_data['pictureUrl'];
	    $data['User']['user_type'] = 3;
	    $data['User']['password'] = rand(1, 99999999);
	    $LinkedIn_user_exist = $this->User->find('first',array('conditions'=>array('User.linkedIn_id'=>$data['User']['linkedIn_id'])));
	    if(isset($LinkedIn_user_exist) && !empty($LinkedIn_user_exist)){
		    if($this->Auth->login($LinkedIn_user_exist)){
			return 1;
		    }
	    }else{
		$this->User->create();
		if($this->User->save($data)){
		    $last_user_id = $this->User->getLastInsertId();
		    $registerd_user = $this->User->findById($last_user_id);
		    $activation_link = 'http://' . $_SERVER["HTTP_HOST"] . '/users/account_confirm/' .base64_encode($registerd_user['User']['id'])."/".base64_encode($registerd_user['User']['email']);
		    $this->Session->setFlash("Your account has been createrd! email varification has been sent please check.");
		    $this->send_mail($registerd_user['User']['email'],'Carreradvise@gmail.com',"Career advisory signUp via linkedIn! :) ",$registerd_user['User']['email'],$data['User']['password'],$activation_link);
		   return 1;
		}else{
		    $same_email_exist = $this->User->find('first',array('conditions'=>array('User.email'=>$data['User']['email'])));
		    $errors = $this->User->validationErrors;
		    if(isset($same_email_exist) && !empty($same_email_exist)){
			if($this->User->updateAll(array('User.linkedIn_id'=>'"'.$data['User']['linkedIn_id'].'"',
						     'User.pictureUrl'=>'"'.$data['User']['pictureUrl'].'"',
						      'User.user_type'=>3,
						     ),array('User.email'=>$same_email_exist['User']['email']))){
			     return 1;
			}else{
			     return 2;
			}
		    }else{
			 return 2;
		    }
		   
		}
	    }
	}
    }
    
   /**
    * Function : fb_connect
    * @access public
    * Description : signup/signIn through facebook
    */
    
     public function fb_connect(){
	$this->autoRender=false;
	if($this->request->is('post')){
	    $facebook_data = $this->request->data['User'];
	    $this->Session->write('loginData',$facebook_data);
	    $data['User']['fb_id'] = $facebook_data['id'];
	    $data['User']['email'] = $facebook_data['email'];
	    $data['User']['firstname'] = $facebook_data['first_name'];
	    $data['User']['lastname'] = $facebook_data['last_name'];
	    $data['User']['user_type'] = 2;
	    $data['User']['password'] = rand(1, 99999999);
	    $facebook_user_exist = $this->User->find('first',array('conditions'=>array('User.fb_id'=>$data['User']['fb_id'])));
	    if(isset($facebook_user_exist) && !empty($facebook_user_exist)){
		    if($this->Auth->login($facebook_user_exist)){
			return 1;
		    }
	    }else{
		$this->User->create();
		if($this->User->save($data)){
		    $last_user_id = $this->User->getLastInsertId();
		    $registerd_user = $this->User->findById($last_user_id);
		    $activation_link = 'http://' . $_SERVER["HTTP_HOST"] . '/users/account_confirm/' .base64_encode($registerd_user['User']['id'])."/".base64_encode($registerd_user['User']['email']);
		    $this->Session->setFlash("Your account has been createrd! email varification has been sent please check.");
		    $this->send_mail($registerd_user['User']['email'],'Carreradvise@gmail.com',"Career advisory signUp via facebook! :) ",$registerd_user['User']['email'],$data['User']['password'],$activation_link);
		   return 1;
		}else{
		    $same_email_exist = $this->User->find('first',array('conditions'=>array('User.email'=>$data['User']['email'])));
		    $errors = $this->User->validationErrors;
		    if(isset($same_email_exist) && !empty($same_email_exist)){
			if($this->User->updateAll(array('User.fb_id'=>'"'.$facebook_data['id'].'"',
						   
						      'User.user_type'=>31,
						     ),array('User.email'=>$same_email_exist['User']['email']))){
			     return 1;
			}else{
			     return 2;
			}
		    }else{
			 return 2;
		    }
		   
		}
	    }
	}
    }
    
}
?>