<?php
class RemoteController extends AppController{
	//var $uses = array('LoginController');
	var $loginController;
	var $fileController;
	private function getLoginController(){
		//singleton to get login controller
		App::import('Controller','Login');
		if(!$this->loginController){
			$this->loginController = new LoginController();
		}
		return $this->loginController;
	}
	private function getFileController(){
		//singleton to get file controller
		App::import('Controller','File');
		if(!$this->fileController){
			$this->fileController = new FileController();
		}
		return $this->fileController;
	}
	public function processRequest($req = "",$data="",$id=""){
		//this function will be called for all ajax requests. According with $req, the correct action will be called
		$this->layout = 'remote';
		$res = array("result"=>"1");

		switch ($req){
			case 'checkLogin':
				$this->login();
				break;
			case 'forgotPassword':
				$this->forgotPassword();
				break;
			case 'getFiles':
				$this->getFiles();
				break;
			case 'setFileDefault': 
				$this->setFileDefault($data);
				break;
			case 'deleteLine':
				$this->deleteLine($data,$id);
				break;
			case 'saveForm':
				$this->saveForm($data);
				break;
		}
	}
	private function saveForm($model){
		//$cont = $model . 'Controller';
		$cont_id = "";
		$objCont = $this->GetControllers($model);
		if($objCont->save($cont_id)){
			$arr_ret = array('model'=>$model,'id'=>$cont_id);
			$ret = json_encode($arr_ret);
			echo $ret;
		}
		
	}
	private function deleteLine($data,$id){
		$arrayData = json_decode($data);
		if($data == 'Files'){
			$this->getFileController()->delete($id);				
		}
		
	}
	private function setFileDefault($id){
		if($this->getFileController()->setDefault($id)){
			$ret = json_encode(array('result'=>'ok'));
		}else{
			$ret = json_encode(array('result'=>'error'));
		}
		echo $ret;
	} 
	public function getFiles(){
		$ret = $this->getFileController()->getFiles();
		$ret_tmp = "";
		foreach($ret as $key=>$value){
			
			$ret_tmp .= json_encode($value['File']) . ","; 
		}
		$params = json_encode($this->getFileController()->getViewParams());
		$params = substr($params,1,strlen($params) - 2);
		$actions = json_encode($this->getFileController()->getViewActions());
		//taking off brackets
		$actions =substr($actions,1,strlen($actions) - 2);
		$ret_tmp = $this->strip_last_comma($ret_tmp);
		$ret_tmp = '{"Files":[' .$ret_tmp . '],' . $params . ',' . $actions . '}'; 
		echo $ret_tmp;
	}
	private function strip_last_comma($ret){
		if(substr($ret,strlen($ret) - 1 ,1) == ","){
			return substr($ret,0,strlen($ret) - 1);
		}else{
			return $ret;
		}
	}
	private function login(){
		$this->getLoginController()->userValidation();
		echo $this->getLoginController()->getDataLogin();
	}
	private function forgotPassword(){
		$this->getLoginController()->forgotPassword();
	}
}