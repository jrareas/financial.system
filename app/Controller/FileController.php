<?php
class FileController extends AppController{
	var $components = array('Session');
	function FileController($request = null,$response = null){
		//seting data to view
		parent::__construct($request,$response);
		$this->set('map',$this->getFieldMap());
		$this->set('view_params',$this->getViewParams());
		$this->set('model','File');
		
	}
	function loadFileModel(){
		if(!ClassRegistry::isKeySet("File")){
			$this->loadModel('File');
		}
	}
	private function initializeDefault(){
		//if other record is marked as default all the other must be initialized as non-default
		$this->loadFileModel();
		$defaults = $this->File->find('all',array('conditions'=>array('user_id'=>CakeSession::read('User.id'),'default_file'=>'1')));
		foreach($defaults as $key=>$value){
			$value['File']['default_file'] = '0';
			$this->File->save($value);
		}
	}
	public function save(&$id){
		//save record and return the id save in json format
		$this->data = $_POST['data'];
		$this->loadFileModel();
		if(isset($this->data['File']['default_file'] ) && ($this->data['File']['default_file'] == 1)){
			$this->initializeDefault();
		}
		if($this->File->save($this->data)){
			$id = $this->File->id;
			return true;
		}
		
	}
	public function add(){
		//only to render the screen for a new record
		$this->loadFileModel();
		$this->layout = 'form';
		$this->data = array('File'=>array('id'=>"",'file_name'=>"",'default_file'=>'','user_id'=>$this->Session->read('User.id')));
		$this->render('/blank_view');
	}
	public function getDefaultFile($user_id=""){
		//get id for default record
		$this->loadFileModel();
		if($user_id == ""){
			$user_id = CakeSession::read('User.id',$this->dataUser['User']['id']);
		}
		$ret = $this->File->find('first',array('fields'=>array('id'),'conditions'=>array('user_id'=>$user_id,'default_file'=> '1')));
		return $ret['File']['id'];
	}
	function getFieldMap(){
		//return the map of fields to be showed on the main screen
		return array('file_name'=>'File Name','default_file'=>'Default','id'=>'id','user_id'=>'user_id','default_file'=>'default_file');
	}
	public function getViewParams(){
		//return params to render the view screen for new or edited records
		return array('Params'=>array('default'=>'default_file'),'fields'=>array('File Name','id','user_id','default_file'),'checkbox'=>array('default_file'));
	}
	public function getViewActions(){
		//return the configuration for the actions on the dashboard table
		return array('Actions'=>array(
									'Edit'=>array('icon'=>'Actions-document-edit-icon.png','onclick'=>"tables.editSelectedLine('Files','/file/edit')")
									,'Delete'=>array('icon'=>'Actions-window-close-icon.png','onclick'=>"tables.deleteSelectedLines('Files','file/delete')")
									,'SetDefault'=>array('icon'=>'default.png','onclick'=>"tables.setDefaultAction('Files')")
									,'New'=>array('icon'=>'Actions-document-new-icon.png','onclick'=>"tables.addLine('Files','/file/add')"))
				);
	}
	public function delete($id){
		//delete record identified by $id§
		$this->loadFileModel();
		$this->File->id = $id;
		$this->File->delete();
	}
	public function edit($id){
		//only to render the screen for a edited record
		$this->loadFileModel();
		$this->layout = 'form';
		$this->data = $this->File->find('first',array('conditions'=>array('id'=>$id)));
		$this->render('/blank_view');
	}
	public function getFiles(){
		//return the files to be showed on dashboard
		App::import('Core','Session');
		$ses = new CakeSession();
		$this->loadFileModel();
		$ret = $this->File->find('all',array('conditions'=>array('user_id'=>$ses->read('User.id'))));
		$fieldMap = $this->getFieldMap();
		$retMapped = array();
		foreach($ret as $keyret=>$value){
			foreach($fieldMap as $key=>$map){
				if(isset($value['File'][$key])){
					$retMapped[$keyret]['File'][$map] = $value['File'][$key]; 
				}
			}
		}
		return $retMapped;
		
	}
	public function setDefault($id){
		//mark record identified by $id as default
		$this->loadFileModel();
		$this->initializeDefault();
		$this->File->id = $id;
		return $this->File->save(array('default_file'=>'1'));
	}
	
} 

