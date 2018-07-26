<?php

namespace Controller;

class TranslationController extends ControllerCommon
{
    public function showPageAction()
    {
        $output['yeeeeep'] = 'УРААААА!';
        $this->render('translation.php', $output);
    }

    public function showErrorPageAction($params = null)
    {
        $output['error'] = isset($params['error']) ? $params['error'] : null;
        $this->render('404.php', $output);
    }

    public function getResponseAction($params = null)
    {
        $data[] = 'Все работает!';
        $this->ajaxResponse($data);
    }
}
