<?php

class DbTable_PedidoTotal extends Zend_Db_Table_Abstract
{
    protected $_name = 'pedidoTotal';
    protected $_primary = 'idPedido';
    
    public function inserirPedidoTotal(array $pedido)
    {
        try {
            $pedido['dataPedido']   = date('Y-m-d H:i:s');
            $this->insert($pedido);
        } catch (Exception $exc) {
            throw new Exception('Erro ao tentar gravar o total pedido na base de dados, verifique os dados digitados e tente novamente.');
        }
    }
    
    public function listaPedidosTotal(){
        try{
            $sql = $this->select()->order('idPedido desc');
            return $this->fetchAll($sql);
        }  catch (Exception $exc){
            throw new Exception('Pedidos não encontrados.');
        }
    }
    
    public function getPedidoTotal($codpedido){
        try{
            $sql = $this->select()->where('idPedido = ?',  $codpedido)->order('idPedido desc');
            return $this->fetchAll($sql);
        }  catch (Exception $exc){
            throw new Exception('Pedido não encontrado.');
        }
    }
    
      public function apagarPedido($codpedido){
        try{
            $this->delete('idPedido = '.$codpedido);
        }  catch (Exception $exc){
            throw new Exception('Pedido não encontrado.');
        }
    }
    
}
?>
