<?php
class DashBoardController extends AppController{
	private function loadElement($elementAlias,$element){
		$this->View->start($elementAlias);
		echo $this->element($element);
		$this->end();
		//echo $this->fetch('head');

	}
	public function index(){
		$this->checkLogin();
		$this->layout = 'dashboard';
		
		//$this->loadElement('tableFiles','tablelist');
	}
	public function getCurrencies(){
		
	}
	public function setDefaultFile($id){
		
	}
}