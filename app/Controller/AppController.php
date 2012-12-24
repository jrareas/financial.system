<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	var $helpers = array('Session');
	private $m_session;
	//public function __construct();
	public function __construct($request=null,$response=null){
		parent::__construct($request,$response);
		//$GLOBALS['session'] = $this->Session;
		App::import('Model','Menu');
		App::import('Component','Session');
		$men = new Menu();
		$this->set('menus',$men->find('all',array('order'=>'parent_menu,menu_order')));
		if($this->name != 'Login'){
			$this->set(array('fullName'=>CakeSession::read('User.firstName') . ' ' . CakeSession::read('User.lastName')));
			$this->set(array('lastLogin'=>CakeSession::read('User.lastLogin')));
		}else{
			$lastname = CakeSession::read('User.lastName'); 
			if($lastname != ""){
				//$this->redirect('/dashboard');
			}
		}
	}
	private function getSession(){
		if(!$this->m_session){
			App::import('Core','Session');
			$this->m_session = new CakeSession();
		}
		return $this->m_session;
	}
	
	public function checkLogin(){
		//App::uses('Session','Components');
		if(!$this->Session->check('User.userName')){
			$this->redirect('/login/index');
		}
	}
	function GetControllers($className)
	{
		App::import('Controller',$className);
		$compclass = $className . 'Controller';
		static $controllers;
		if(!isset($controllers[$className])) {
			$controllers[$className] = new $compclass;
		}
		$class = &$controllers[$className];
		return $class;
	}
	
}
