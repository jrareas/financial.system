<?php
class LoginController extends AppController{
	var $components = array('Session');
	
	
	var $user;
	var $password;
	var $dataLogin;
	var $dataUser;
	private $m_session;
	private function getSession(){
		if(!$this->m_session){
			App::import('Core','Session');
			$this->m_session = new CakeSession();
		}
		return $this->m_session;
	}
	public function index(){
		$this->layout = 'login';
	}
	public function logOff(){
		$this->getSession()->delete('User');
		$this->redirect('/');
	}
	public function userValidation(){
		$this->user = $_POST['data']['login']['username'];
		$this->password = $_POST['data']['login']['password'];
		$this->getDataUser();
		if($this->LoginValido()){
			$this->setLastLogin();
			$this->dataLogin['loginResult'] = 'ok';
			$this->dataLogin['lastLogin'] = $this->dataUser['User']['last_login'];
			$this->dataLogin['firstName'] = $this->dataUser['User']['user_first_name'];
			$this->dataLogin['lastName'] = $this->dataUser['User']['user_last_name'];
			
			App::import('Core','Session');
			App::uses('FileController', 'Controller');
			$FileCont = new FileController();
			$ses = new CakeSession();
			
			$ses->write('User.userName',$this->user);
			$ses->write('User.id',$this->dataUser['User']['id']);
			$ses->write('User.lastLogin',$this->dataUser['User']['last_login']);
			$ses->write('User.lastName',$this->dataUser['User']['user_last_name']);
			$ses->write('User.firstName',$this->dataUser['User']['user_first_name']);
			$ses->write('User.sessionStart', getdate());
			$ses->write('User.sessionRenew', getdate());
			$ses->write('File.selected',$FileCont->getDefaultFile());
		}else{
			$this->dataLogin['errorMessage'] = 'User or Password does not match.';
			$this->dataLogin['loginResult'] = 'error';
		}
	}
	public function setLastLogin(){
		$data['id'] = $this->dataUser['User']['id'];
		$data['last_login'] = getdate();
		$this->User->save($data); 
	}
	public function LoginValido(){
		App::uses('Security','Utility');
		return (isset($this->dataUser['User']['user_id']) && $this->dataUser['User']['user_password'] == Security::hash($this->password,null,true));
	}
	private function getDataUser(){
		$this->loadModel('User');
		if((!isset($this->dataUser['User'])) || ($this->dataUser['User']['user_id'] != $_POST['data']['login']['username'])){
			$this->dataUser = $this->User->find('first',array('conditions'=>array('user_id'=>$_POST['data']['login']['username'])));
		}
		return $this->dataUser;
	}
	public function getDataLogin(){
		return json_encode($this->dataLogin);
	}
	public function forgotPassword(){
		$this->getDataUser();
		$ret = array();
		if(!isset($this->dataUser['User']['id'])){
			$ret['valid'] = 0;
			$ret['message'] = 'The User ID provided could not be found on our system. Please, check the spelling and submit the request again.';
		}else{
			$ret['valid'] = 1;
			$ret['message'] = 'A new password was sent to ' . $this->dataUser['User']['email'] . '. Use the password to log in the system.';
			$this->emailNewPassword($this->dataUser['User']['email']);
		}
		echo json_encode($ret);
	}
	public function requestPassConfirmation($code){
		$this->layout = 'Emails/html/newpassword';
		$this->loadModel('User');
		$user = $this->User->find('first',array('conditions'=>array('new_password_code_request'=>$code)));
		if($user){
			$this->User->id = $user['User']['id'];
			$this->User->save(array('user_password' => $user['User']['new_password']));
			$mess = "<p>Congratulations!!</p>
					Your password was changed sucessfully.<br><br>
					<a href=http://" . $_SERVER['HTTP_HOST'] . ">Home</a>";
		
			 
		}else{
			$mess = 'Code not found!!!';
		}
		$this->set('message',$mess);
		
		
	}
	function emailNewPassword($to){
		App::uses('Security','Utility');
		$this->loadModel('User');
		$this->getDataUser();
		$newPass = $this->generateRandomString(10);
		$newPassCodeRequest = $this->generateRandomString(20);
		$this->User->id = $this->dataUser['User']['id'];
		$this->User->save(array('new_password'=>Security::hash($newPass,null,true) ,'new_password_code_request'=>$newPassCodeRequest));
		$viewVars = array('fullName'=>$this->dataUser['User']['user_first_name'] . " " .$this->dataUser['User']['user_last_name']
				,'newPassword' => $newPass
				,'linkConfirmation'=>"<a href=". $_SERVER['HTTP_ORIGIN'] . "/login/requestPassConfirmation/" . $newPassCodeRequest . ">". $_SERVER['HTTP_ORIGIN'] . "/login/requestPassConfirmation/" . $newPassCodeRequest . "</a>"
				);
		$this->sendMailUser($to,'','Financial System - New Password Request','newpassword','newpassword',$viewVars);
	}
	private function sendMailUser($to,$message,$subject,$template='default',$view='default',$viewVars=array()){
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail('gmail');
		$email->viewVars($viewVars);
		$email->template($view,$template);
		$email->emailFormat('html');
		$email->from(array('noreply@pieceofcake.no-ip.org' => 'Financial System'));
		$email->to($to);
		$email->subject($subject);
		$email->send($message);
	}
	private function generateRandomString($length = 10) {
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
}

?>