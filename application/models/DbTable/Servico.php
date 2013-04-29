<?php

class DbTable_Servico extends Zend_Db_Table_Abstract
{
    protected $_name = 'servicos';
    protected $_primary = 'idServico';
    
    public function inserirServico(array $data)
    {
        try {
            $output = array_map(array(new Zend_Filter_StripTags(), 'filter'), $data);
            $newRow = $this->createRow($output);
            return $newRow->save();
        } catch (Exception $exc) {
            throw new Exception('Erro ao tentar gravar o servico na base de dados, verifique os dados digitados e tente novamente.');
        }
    }
    
    public function listaServicos(){
        try{
             $sql = $this->select()->order('servico');
            return $this->fetchAll($sql);
        }  catch (Exception $exc){
            throw new Exception('Serviços não encontrados.');
        }
    }
    
    public function getServico($nomeservico){
        try{
            $sql = $this->select()->where('servico like ?',  "%{$nomeservico}%")->order('servico');
            return $this->fetchRow($sql);
        }  catch (Exception $exc){
            throw new Exception('Serviço não encontrado.');
        }
    }
    
    public function getValorServico($idServico){
        try{
            $sql = $this->select()->from(array('p'=>  $this->_name), array('preco'))->where('idServico = ?',  $idServico);
            $retorno = $this->fetchRow($sql);
            return $retorno->preco;
        }  catch (Exception $exc){
            throw new Exception('Serviço não encontrado.');
        }
    }
    
}
?>
