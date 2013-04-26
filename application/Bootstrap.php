<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initConfig()
    {
        $zendConfig = new Zend_Config_Ini(
            APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV
        );
        Zend_Registry::set('Zend_Config', $zendConfig);
    }
    
    protected function _initLocale()
    {
        Zend_Registry::set('Zend_Locale', new Zend_Locale('pt_BR'));
    }
    
     protected function _initAutoloader()
    {
        new Zend_Loader_Autoloader_Resource(
            array('basePath' => APPLICATION_PATH, 'namespace' => '',
                    'resourceTypes' => array(
                            'model' => array('namespace' => 'Model',
                                    'path' => 'models',),
                            'dbtable' => array(
                                    'path' => 'models/DbTable/',
                                    'namespace' => 'DbTable')),)
        );
    }
    
}

