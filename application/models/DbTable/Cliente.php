<?php

class DbTable_Cliente extends Zend_Db_Table_Abstract
{
    protected $_name = 'clientes';
    protected $_primary = 'idCliente';
    
    public function insertCliente(array $data)
    {
        try {
            $output = array_map(array(new Zend_Filter_StripTags(), 'filter'), $data);
            $newRow = $this->createRow($output);
            return $newRow->save();
        } catch (Exception $exc) {
            throw new Exception('Erro ao tentar gravar cliente na base de dados, verifique os dados digitados e tente novamente.');
        }
    }
    
}
?>
