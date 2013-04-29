<?php

class DbTable_Cliente extends Zend_Db_Table_Abstract
{
    protected $_name = 'clientes';
    protected $_primary = 'idCliente';
    
    public function inserirCliente(array $data)
    {
        try {
            $output = array_map(array(new Zend_Filter_StripTags(), 'filter'), $data);
            $newRow = $this->createRow($output);
            return $newRow->save();
        } catch (Exception $exc) {
            throw new Exception('Erro ao tentar gravar cliente na base de dados, verifique os dados digitados e tente novamente.');
        }
    }
    
    public function listaClientes(){
        try{
            $sql =  $this->select()->order('nome');
            return $this->fetchAll($sql);
        }  catch (Exception $exc){
            throw new Exception('Clientes não encontrados.');
        }
    }
    
    public function getCliente($nomecliente){
        try{
            $sql = $this->select()->where('nome like ?',  "%{$nomecliente}%")->order('nome');
            return $this->fetchAll($sql);
        }  catch (Exception $exc){
            throw new Exception('Cliente não encontrado.');
        }
    }
    
    public function apagarCliente($codcliente){
        try{
            $pedido = new DbTable_Pedido();
            $pedidos = $pedido->getPedidosByCliente($codcliente);
            $this->delete('idCliente = '.$codcliente);
            if(count($pedidos)>0){
                $pedidoTotal = new DbTable_PedidoTotal();
                foreach ($pedidos as $p){
                    $pedidoTotal->apagarPedido($p->idPedido);
                }
                $pedido->apagarPedidoCliente($codcliente);
            }
            
        }  catch (Exception $exc){
            throw new Exception('Cliente não encontrado.'.$exc->getMessage());
        }
    }
    
}
?>
