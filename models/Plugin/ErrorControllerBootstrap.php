<?php

class Redirect_Model_Plugin_ErrorControllerBootstrap extends Zend_Controller_Plugin_Abstract
{
    /**
     * In postDispatch, we analyse the request in order to catch 404 exception and save them or redirect the user.
     * 
     * @see Zend_Controller_Plugin_Abstract::postDispatch()
     * @var Zend_Controller_Request_Abstract $request
     */
    public function postDispatch(Zend_Controller_Request_Abstract $request) {
        $response = $this->getResponse();

        if ($response->isException()) {
            $datas = array();

            $exceptions = $response->getException();
            foreach ($exceptions as $exception) {
                //We store only the 404 code
                if ($exception instanceof Zend_Controller_Dispatcher_Exception || $exception->getCode() == '404') {
                    $row = Centurion_Db::getSingleton('redirect/lifo')->findOneByOld_permalink($request->getRequestUri());

                    //If a redirection exist, we use them
                    if (null !== $row) {
                        $request->setParam('history', $row);
                        $request->setControllerName('redirect');
                        $request->setModuleName('redirect');
                        $request->setActionName('history');

                        $request->setDispatched(false);
                    } else {
                        //Else we log the exception. Administrator can use backoffice to redirect this 404 to any page
                        $datas['url'] = $request->getRequestUri();
                        $datas['message'] = $exception->getMessage();
                        list($row, ) = Centurion_Db::getSingleton('redirect/log')->getOrCreate($datas);
                        
                        $row->nb++;
                        $row->save();
                    }
                }
            }
        }
    }
}
