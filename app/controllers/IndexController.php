<?php
declare(strict_types=1);

namespace Dex\Microblog\Controller;

class IndexController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function fourOhFourAction(){
        return $this->view->pick('fourohfour');
    }

}

