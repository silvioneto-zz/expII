<?php

class ClientesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         //$data = array('nome'=> 'Rafael', 'telefone'=> '', 'email'=>'rafa@el.com.br');
        try {
            $obj = new DbTable_Cliente();
            //var_dump($obj->insertCliente($data));
            //$this->view->msg = "Cliente inserido com sucesso!";
            $this->view->dados = $obj->listaClientes();
            $this->view->erro = 0;
            
        } catch (Exception $exc) {
            $this->view->erro = 1;
            $this->view->msg = $exc->getMessage();
        }
    }
    
    

}

