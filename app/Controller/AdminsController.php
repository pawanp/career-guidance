<?php
ob_start();
class AdminsController extends AppController{
    
    public $name = 'Admins';
    
     public $components = array('Session','Email','Cookie');
    
     function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('admin_login');
        $this->loadModel('User');
              
    }
    
    /**
    * Function : admin_login
    * @access public
    * Description : used to login in backend
    */
     
    public function admin_login(){
        $this->layout='admin_login';
         if ($this->request->is('post')) {
            $username = $this->request->data['User']['username'];
            $password = $this->request->data['User']['password'];
            $admin_user = $this->User->find('first',array('conditions'=>array('User.username'=>$username,'User.password'=>md5($password))));
            if(empty($admin_user)){
                $admin_user = $this->User->find('first',array('conditions'=>array('User.username'=>$username,'User.password'=>AuthComponent::password($password))));
            }
            if(isset($admin_user) && !empty($admin_user)){
                if($admin_user['User']['role']==1 && $admin_user['User']['level']==1){
                    if ($this->Auth->login($this->request->data)) {
                        $this->redirect(array('controller'=>'admins','action'=>'admin_dashboard'));
                        // Prior to 2.3 use
                        // `return $this->redirect($this->Auth->redirect());`
                    } else {
                       $this->Session->setFlash(__('Username or password is incorrect'),'default',array(),'auth');
                    }
                }else{
                    $this->Session->setFlash(__('You dont have permission to access this location'),'default',array(),'auth');
                }
            }else{
                $this->Session->setFlash(__('Username or password is incorrect'),'default',array(),'auth');
            }
        }
    }
    
    /**
    * Function :admin_logout
    * @access public
    * Description : admin logout function
    */
    
    public function admin_logout(){
        if($this->Auth->logout()){
         $this->redirect(array('controller'=>'admins','action'=>'admin_login'));
        }
         
    }
    
   /**
    * Function :admin_dashboard
    * @access public
    * Description : admin dashboard
    */
    
    public function admin_dashboard(){ 
         $this->layout='admin';
         
    }
    
   /**
    * Function :admin_adduser
    * @access public
    * Description : used to add user from backend
    */
    
    public function admin_adduser(){
         $this->layout='admin';
         if ($this->request->is('post')) {
             $random_password = rand(1, 99999999);
             $this->request->data['User']['password'] = $random_password;
		$this->User->create();
		    if($this->User->save($this->request->data)){
			$last_user_id = $this->User->getLastInsertId();
			$registerd_user = $this->User->findById($last_user_id);
			$activation_link = 'http://' . $_SERVER["HTTP_HOST"] . '/users/account_confirm/' .base64_encode($registerd_user['User']['id'])."/".base64_encode($registerd_user['User']['email']);
			$this->Session->setFlash("User successfully saved");
			$this->admin_send_mail($registerd_user['User']['email'],'CarreradviseAdmin@gmail.com',"BOOM! !! Welcome to Career Guidance portal! :) ",$registerd_user['User']['username'],$this->request->data['User']['password'],$activation_link);
		       $this->redirect($this->referer());
		    }else{
			$this->Session->setFlash("Some problem occured ! please try again");
		    }
	}
         
    }
    
     /**
    * Function : admin_send_email
    * @access public
    * Description : used to send activation link email
    */
    
    function admin_send_mail($to,$from,$subject,$username,$password,$activation_link){
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

}
?>