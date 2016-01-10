<?php
declare(strict_types=1);

namespace Controllers;

use Framework\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        $loggedUsername =  $this->session->escapedUsername;
        if($loggedUsername !== null){
            $this->redirect("/PhoneNumber");
        }
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'home');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.home');
    }

    /**
     * @Get
     * @Route("Home/Login")
     * @throws \Exception
     */
    public function login(){
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'login');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.login');
    }
}