<?php
class AdminController extends Zend_Controller_Action
{
    const USER = 'admin';
    const PASS = 'admin';

    public function preDispatch()
    {
        $this->_helper->_layout->setLayout('bootstrap');
        //$this->_helper->layout()->disableLayout(); 
        //$this->_helper->viewRenderer->setNoRender(true);
    }

    public function init()
    {
        
        /*
        var_dump(!Zend_Registry::isRegistered('logado'));
        if(!Zend_Registry::isRegistered('logado')){ 
            Zend_Registry::set('logado', false);
        }elseif(Zend_Registry::get('logado') == true){
            $this->_redirect($this->_getParam('controller')."/dashboard");
        }
         * */
         
    }
    
    public function indexAction()
    {
        if($this->getRequest()->isPost()){
             If($this->getParam('user') == self::USER and $this->getParam('pass') == self::PASS){
                 $this->_redirect($this->_getParam('controller')."/dashboard");
                 return;
             }else{
                 $this->view->erro = 1;
                 $this->view->msg  = 'Usuário e/ou senha incorretos.';
             }
         }
    }
    
    public function dashboardAction()
    { 
        if($this->getRequest()->isPost()){
                try {
                     $obj = new DbTable_Cliente();
                     $this->view->dados = $obj->getCliente($this->getParam('cliente'));
                     $this->view->erro = 0;
                 } catch (Exception $exc) {
                     $this->view->erro = 1;
                     $this->view->msg = $exc->getMessage();
                 }
         }else{
                try {
                     $obj = new DbTable_Cliente();
                     $this->view->dados = $obj->listaClientes();
                     $this->view->erro = 0;
                 } catch (Exception $exc) {
                     $this->view->erro = 1;
                     $this->view->msg = $exc->getMessage();
                 }
         }
             
    }
    
    public function deslogarAction(){
        Zend_Registry::set('logado', false);
        $this->_redirect();
    }
    
}
    
 ?>