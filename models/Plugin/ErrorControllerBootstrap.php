<?php

class History_Model_Plugin_ErrorControllerBootstrap extends Zend_Controller_Plugin_Abstract
{
    public function postDispatch(Zend_Controller_Request_Abstract $request) {
        $response = $this->getResponse();

        if ($response->isException()) {
            $datas = array();

            $exceptions = $response->getException();
            foreach ($exceptions as $exception) {
                if ($exception instanceof Zend_Controller_Dispatcher_Exception || $exception->getCode() == '404') {
                    $row = Centurion_Db::getSingleton('history/lifo')->findOneByOld_permalink($request->getRequestUri());

                    if (null !== $row) {
                        $request->setParam('history', $row);
                        $request->setControllerName('history');
                        $request->setModuleName('history');
                        $request->setActionName('history');

                        $request->setDispatched(false);
                    } else {
                        $datas['url'] = $request->getRequestUri();
                        $datas['message'] = $exception->getMessage();
                        list($row, ) = Centurion_Db::getSingleton('history/log')->getOrCreate($datas);

                        $row->nb++;
                        $row->save();
                    }
                }
            }
        }

        /*
        if ($response->isRedirect()) {

        }
        */

    }
}
