<?php

class ClientesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         $data = array('nome'=> 'Saulo', 'telefone'=> '987547455', 'email'=>'saulo@saulo.com.br');
        try {
            $obj = new DbTable_Cliente();
            $obj->insertCliente($data);
            $this->view->erro = 0;
            $this->view->msg = "Cliente inserido com sucesso!";
        } catch (Exception $exc) {
            $this->view->erro = 1;
            $this->view->msg = $exc->getMessage();
        }
    }

}

