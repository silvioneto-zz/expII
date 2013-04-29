<?php

class Expii_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $modelAcl = new Model_Acl();
        $modelAuth = new Model_Auth();
        $role = $modelAuth->getRole();

        $resource = $request->getControllerName();
        $permission = $request->getActionName();

        if (!$modelAcl->isAllowed($role, $resource, $permission)) {
            /**
            * @TODO create a deny page to redirect user
            */
            $request->setControllerName('error')->setActionName('deny');
        }
    }
}
?>