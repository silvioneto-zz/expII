<?php
class AdminController extends Zend_Controller_Action
{
    const USER = 'admin';
    const PASS = 'admin';

    public function preDispatch()
    {
        //$this->_helper->_layout->setLayout('bootstrap');
        //$this->_helper->layout()->disableLayout(); 
        //$this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function init() {
        $this->_helper->_layout->setLayout('bootstrap');
        if($this->_getParam('action') != 'login'){
            $this->view->showLogout = true;
        }
    }

   public function indexAction(){
       $this->_redirect($this->_getParam('controller')."/login");
   }
   
    public function loginAction()
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
        
             
    }
    
    public function clientesAction(){
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
    
    public function servicosAction(){
        if($this->getRequest()->isPost()){
                try {
                     $obj = new DbTable_Servico();
                     $this->view->dados = $obj->getServico($this->getParam('servico'));
                     $this->view->erro = 0;
                 } catch (Exception $exc) {
                     $this->view->erro = 1;
                     $this->view->msg = $exc->getMessage();
                 }
         }else{
                try {
                     $obj = new DbTable_Servico();
                     $this->view->dados = $obj->listaServicos();
                     $this->view->erro = 0;
                 } catch (Exception $exc) {
                     $this->view->erro = 1;
                     $this->view->msg = $exc->getMessage();
                 }
         }
                             
    }
    
     public function pedidosAction(){
        if($this->getRequest()->isPost()){
                try {
                     $obj = new DbTable_Pedido();
                     $this->view->dados = $obj->getPedido($this->getParam('pedido'));
                     $this->view->erro = 0;
                 } catch (Exception $exc) {
                     $this->view->erro = 1;
                     $this->view->msg = $exc->getMessage();
                 }
         }else{
                try {
                     $obj = new DbTable_Pedido();
                     $this->view->dados = $obj->listaPedidos();
                     $this->view->erro = 0;
                 } catch (Exception $exc) {
                     $this->view->erro = 1;
                     $this->view->msg = $exc->getMessage();
                 }
         }
    }
    
    public function inserirPedidoAction(){
        
        $obj = new DbTable_Cliente();
        $this->view->clientes = $obj->listaClientes();
        $obj = new DbTable_Servico();
        $this->view->servicos = $obj->listaServicos();
         
        if($this->getRequest()->isPost()){
            $params = $this->getAllParams();
            $data = array('idCliente'=>$params['cliente']);
            
                if($params['servico1'] != ''){
                    $data['idServico'][] = $params['servico1'];
                }
                if($params['servico2'] != ''){
                    $data['idServico'][] = $params['servico2'];
                }
                if($params['servico3'] != ''){
                    $data['idServico'][] = $params['servico3'];
                }
                
            try{
                
                $obj = new DbTable_Pedido();
                $obj->inserirPedido($data);
                $this->view->erro = 0;
                $this->view->msg = "Pedido inserido com sucesso!";
                $this->_redirect($this->_getParam('controller')."/pedidos");
            } catch (Exception $exc) {
                     $this->view->erro = 1;
                     $this->view->msg = $exc->getMessage();
            }
              
          }
    }
    
    public function deslogarAction(){
        $this->_redirect();
    }
    
}
    
 ?>