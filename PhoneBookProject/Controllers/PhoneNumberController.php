<?php
declare(strict_types=1);

namespace Controllers;

use Framework\Normalizer;
use Framework\BaseController;
use Models\ViewModels\PhoneNumberController\IndexViewModel;
use Models\ViewModels\PhoneNumberController\PhoneNumberViewModel;
use Models\ViewModels\PhoneNumberController\SearchViewModel;
use Models\BindingModels\EditPhoneNumberBindingModel;
use Models\BindingModels\PhoneNumberBindingModel;



class PhoneNumberController extends BaseController
{

    public function index() : IndexViewModel
    {
        $loggedUsername =  $this->session->escapedUsername;
        if($loggedUsername === null){
            throw new \Exception;
        }
        $this->db->prepare("SELECT p.id as id, p.name as name, p.number as phonenumber
                            From phoneNumber p
                            JOIN users u ON u.id = p.user_id
                            WHERE u.username = ?
                            ORDER BY p.name",
            array($loggedUsername));
        $response = $this->db->execute()->fetchAllAssoc();
        $PhoneNumbers = array();
        foreach ($response as $c) {
            $PhoneNumber = new PhoneNumberViewModel($c['id'], $c['name'], $c['phonenumber']);
            $PhoneNumbers[] = $PhoneNumber;
        }

        $indexViewModel = new IndexViewModel($PhoneNumbers);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $indexViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.PhoneNumbers');

        return $indexViewModel;
    }

    /**
     * @Route("PhoneNumber/search")
     * @Post
     */
    public function search()
    {
        //$_POST['search'];
        $loggedUsername =  $this->session->escapedUsername;
        if($loggedUsername === null){
            throw new \Exception;
        }
        if(preg_match('/^[0-9]*$/',$_POST['search'])) {
            $this->db->prepare("SELECT p.id as id, p.name as name, p.number as phonenumber
                            From phoneNumber p
                            JOIN users u ON u.id = p.user_id
                            WHERE u.username = ? AND p.number like ?
                            ORDER BY p.name",
                array($loggedUsername,'%'.$_POST['search'].'%'));
        }
        else {
            $this->db->prepare("SELECT p.id as id, p.name as name, p.number as phonenumber
                            From phoneNumber p
                            JOIN users u ON u.id = p.user_id
                            WHERE u.username = ? AND p.name like ?
                            ORDER BY p.name",
                array($loggedUsername,'%'.$_POST['search'].'%'));
        }

        $response = $this->db->execute()->fetchAllAssoc();
        $PhoneNumbers = array();
        foreach ($response as $c) {
            $PhoneNumber = new PhoneNumberViewModel($c['id'], $c['name'], $c['phonenumber']);
            $PhoneNumbers[] = $PhoneNumber;
        }

        $searchViewModel = new SearchViewModel($PhoneNumbers);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $searchViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.PhoneNumbers');

        return $searchViewModel;
    }
    /**
     * @Route("PhoneNumber/addNumber")
     */
    public function create()
    {
        $_SESSION['confIdAddPhoneNumber'] = $this->input->get(2);
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'addPhoneNumber');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.addPhoneNumberLayout');
    }

    /**
     * @Route("PhoneNumber/add")
     * @Post
     * @Authorize error:("Error message")
     * @param PhoneNumberBindingModel $model
     * @throws \Exception
     */
    public function add(PhoneNumberBindingModel $model)
    {
        $loggedUsername =  $this->session->escapedUsername;
        if($loggedUsername === null){
            throw new \Exception;
        }
        $this->db->prepare("SELECT
                            id, username
                            FROM users
                            WHERE username LIKE ?",
            array($loggedUsername));
        $response = $this->db->execute()->fetchRowAssoc();
        $userId = Normalizer::normalize($response['id'], 'noescape|int');
        if(strlen($model->getName())<=2||$model->getName()===null)
        {
            $_SESSION['error']='Invalid name!';
            $_SESSION['errornumber']=400;
            $this->redirect("/PhoneNumber/addNumber");
            throw new \Exception("Invalid name!", 400);
        }        if(strlen($model->getName())<=2||$model->getName()===null)
        {
            $_SESSION['error']='Invalid name!';
            $_SESSION['errornumber']=400;
            $this->redirect("/PhoneNumber/addNumber");
            throw new \Exception("Invalid name!", 400);
        }
        if(!preg_match('/\b\d{3}[-.]?\d{3}[-.]?\d{4}\b/',$model->getNumber()))
        {
            $_SESSION['error']='Invalid phone number format!';
            $_SESSION['errornumber']=400;
            $this->redirect("/PhoneNumber/addNumber");
            throw new \Exception("Invalid phone number format!", 400);
        }

        $this->db->prepare("SELECT id
                                FROM phoneNumber
                                WHERE number = ? AND user_id = ?",
            array($model->getNumber(),$userId));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        if ($id !== null) {
            $phonenumber = $model->getNumber();
            $_SESSION['error']="Phone number '$phonenumber' already exists!";
            $_SESSION['errornumber']=400;
            $this->redirect("/PhoneNumber/addNumber");
            throw new \Exception("Phone number '$phonenumber' already exists!", 400);
        }
        $confId = $_SESSION['confIdAddPhoneNumber'];

        $this->db->prepare("INSERT
                            INTO phoneNumber
                            (name, user_id, number)
                            VALUES (?, ?, ?)",
            array($model->getName(),$userId, $model->getNumber(), $confId));
        $this->db->execute();

        $this->db->prepare("SELECT
                            id
                            FROM phoneNumber
                            WHERE name = ? AND number = ?",
            array($model->getName(), $model->getNumber()));
        $response = $this->db->execute()->fetchRowAssoc();
        $PhoneNumberId = Normalizer::normalize($response['id'], 'noescape|int');

        $this->redirect("/PhoneNumber");
    }

    /**
     * @Route("PhoneNumber/editPhoneNumber/{id:int}/edit")
     */
    public function editPhoneNumber() {
        $_SESSION['PhoneNumberToEdit'] = $this->input->get(2);
        $this->db->prepare("SELECT name, number
                            FROM phoneNumber
                            WHERE id = ?",
            array($_SESSION['PhoneNumberToEdit']));
        $response = $this->db->execute()->fetchRowAssoc();
        $_SESSION['PnoneName']= $response['name'];
        $_SESSION['PnoneNumber']= $response['number'];
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'editPhoneNumber');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.editPhoneNumberLayout');
    }

    /**
     * @Route("PhoneNumber/edit")
     * @Authorize error:("Error message")
     * @Post
     * @param EditPhoneNumberBindingModel $model
     * @throws \Exception
     */
    public function edit(EditPhoneNumberBindingModel $model)
    {
        $this->db->prepare("SELECT id
                                FROM phoneNumber
                                WHERE number = ?",
            array($model->getPhoneNumber()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        if ($id !== null) {
            $phonenumber = $model->getPhoneNumber();
            $_SESSION['error']="Phone number '$phonenumber' already exists!";
            $_SESSION['errornumber']=400;
            $this->redirect("/PhoneNumber/editPhoneNumber/".$_SESSION['PhoneNumberToEdit']."/edit");
            throw new \Exception("Phone number '$phonenumber' already exists!", 400);
        }
        if(strlen($model->getName())<=2||$model->getName()===null)
        {
            $_SESSION['error']='Invalid name!';
            $_SESSION['errornumber']=400;
            $this->redirect("/PhoneNumber/editPhoneNumber/".$_SESSION['PhoneNumberToEdit']."/edit");
            throw new \Exception("Invalid name!", 400);
        }
        if(!preg_match('/\b\d{3}[-.]?\d{3}[-.]?\d{4}\b/',$model->getPhoneNumber()))
        {
            $_SESSION['error']='Invalid phone number format!';
            $_SESSION['errornumber']=400;
            $this->redirect("/PhoneNumber/editPhoneNumber/".$_SESSION['PhoneNumberToEdit']."/edit");
            throw new \Exception("Invalid phone number format!", 400);
        }
        $this->db->prepare("UPDATE phoneNumber
                            SET name = ?, number = ?
                            WHERE id = ?",
            array($model->getName(), $model->getPhoneNumber(), $_SESSION['PhoneNumberToEdit']));
        $this->db->execute();

        $this->db->prepare("SELECT
                            id
                            FROM phoneNumber
                            WHERE name = ? AND number = ?",
            array($model->getName(), $model->getPhoneNumber()));
        $response = $this->db->execute()->fetchRowAssoc();
        $PhoneNumberId = Normalizer::normalize($response['id'], 'noescape|int');

        $this->redirect("/PhoneNumber");
    }

    /**
     * @Get
     * @Route("PhoneNumber/removePhoneNumber/{id:int}/remove")
     */
    public function removePhoneNumber() {
        $_SESSION['PhoneNumberIdToDelete'] = $this->input->get(2);
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'removePhoneNumber');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.deletePhoneNumber');
    }

    /**
     * @Post
     * @Authorize error:("Error message")
     * @Route("PhoneNumber/deletePhoneNumber")
     */
    public function deletePhoneNumber() {
        $this->db->prepare("DELETE
                            FROM phoneNumber
                            WHERE id = ?",
            array($_SESSION['PhoneNumberIdToDelete']));
        try {
            $response = $this->db->execute()->fetchAllAssoc();
            if (!$response) {
                throw new \Exception('No PhoneNumber matching provided id exist!', 400);
            }
        }
        catch(\Exception $e) {
            $this->redirect('/PhoneNumber');
        }
    }
}