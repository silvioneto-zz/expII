<?php

class DbTable_Pedido extends Zend_Db_Table_Abstract
{
    protected $_name = 'pedidos';
    protected $_primary = 'idPedido';
    
    public function inserirPedido(array $data)
    {
        try {
            
            /**
             * Tratamento de chave no pedido, pois sqlite é limitado 
             * para oferecer uma tabela com chave composta e auto_increment
             */
            $sql = $this->select()->from(array('p'=>  $this->_name), array('idPedido'))->order('idPedido desc')->limit('1');
            $ultPedido                    = $this->fetchRow($sql);
            $pedido                         = array();
            $pedido['idPedido']    = (count($ultPedido)>0?$ultPedido->idPedido+1:1);
            $pedido['idCliente']   = $data['idCliente'];
            $valorTotal                  = 0;
            $servico = new DbTable_Servico();
            foreach($data['idServico'] as $idServico){
                $pedido['idServico'] = $idServico;
                $valorTotal               += $servico->getValorServico($idServico);
                $this->insert($pedido);
            }
            
            $pedidoTotal = array();
            $pedidoTotal['idPedido']        = $pedido['idPedido'];
            $pedidoTotal['totalPedido']  = $valorTotal;
            $obj = new DbTable_PedidoTotal();
            $obj->inserirPedidoTotal($pedidoTotal);
            
        } catch (Exception $exc) {
            throw new Exception('Erro ao tentar gravar o pedido na base de dados, verifique os dados digitados e tente novamente.'.$exc->getMessage());
        }
    }
    
    public function listaPedidos(){
        try{
            $sql = $this->select()
                                ->from(array('p' => $this->_name), 
                                                        array('idPedido'))
                                ->setIntegrityCheck(false)
                                ->join(array('c' => 'clientes'),
                                                    'p.idCliente = c.idCliente',
                                                     array('nome'))
                                ->join(array('t' => 'pedidoTotal'),
                                                    'p.idPedido = t.idPedido',
                                                    array('totalPedido', 'dataPedido'))
                                ->group('p.idPedido')
                                ->order('p.idPedido desc');
            return $this->fetchAll($sql);
        }  catch (Exception $exc){
            throw new Exception('Pedidos não encontrados.');
        }
    }
    
    public function getPedido($codpedido){
        try{
             $sql = $this->select()
                                ->from(array('p' => $this->_name), 
                                                        array('idPedido'))
                                ->setIntegrityCheck(false)
                                ->join(array('c' => 'clientes'),
                                                    'p.idCliente = c.idCliente',
                                                     array('nome'))
                                ->join(array('t' => 'pedidoTotal'),
                                                    'p.idPedido = t.idPedido',
                                                    array('totalPedido', 'dataPedido'))
                                 ->where('p.idPedido = ?',  $codpedido)
                                ->group('p.idPedido')
                                ->order('p.idPedido desc');
            return $this->fetchAll($sql);
        }  catch (Exception $exc){
            throw new Exception('Pedido não encontrado.');
        }
    }
    
        public function getPedidoDetalhe($codpedido){
        try{
            $sql = $this->select()
                                ->from(array('p' => $this->_name), 
                                                        array('idPedido'))
                                ->setIntegrityCheck(false)
                                ->join(array('c' => 'clientes'),
                                                    'p.idCliente = c.idCliente',
                                                     array('nome'))
                                ->join(array('s' => 'servicos'),
                                                    'p.idServico = s.idServico',
                                                     array('servico','preco','duracao'))
                                ->join(array('t' => 'pedidoTotal'),
                                                    'p.idPedido = t.idPedido',
                                                    array('totalPedido', 'dataPedido'))
                                 ->where('p.idPedido = ?',  $codpedido)
                                ->order('p.idPedido desc');
            return $this->fetchAll($sql);
        }  catch (Exception $exc){
            throw new Exception('Detalhe do pedido não encontrado.');
        }
    }
    
}
?>
