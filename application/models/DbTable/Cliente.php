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
            return $this->fetchRow($sql);
        }  catch (Exception $exc){
            throw new Exception('Cliente não encontrado.');
        }
    }
    
}
?>
