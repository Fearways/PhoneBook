<?php
declare(strict_types=1);

namespace Controllers;

use Framework\BaseController;
use Models\BindingModels\LoginBindingModel;
use Models\BindingModels\RegisterBindingModel;

class UserController extends BaseController
{
    /**
     * @NotLogged
     * @param LoginBindingModel $model
     * @throws \Exception
     */
    public function login(LoginBindingModel $model)
    {
        $this->db->prepare("SELECT u.id as id, u.username as username, u.password as pass
                            FROM users u
                            WHERE username = ? AND password = ?",
            array($model->getUsername(), $model->getPassword()));
        $response = $this->db->execute()->fetchRowAssoc();
        if (!$response) {
            throw new \Exception('No user matching provided username or password!', 400);
        }
        $id = $response['id'];
        $username = $response['username'];
        $this->session->_login = $id;
        $this->session->_username = $model->getUsername();
        $this->session->escapedUsername = $username;
        $_SESSION['username'] = $response['username'];
        $this->redirect('/');
    }


    public function logout()
    {
        $this->session->destroySession();
        $this->redirect('/');
    }

    /**
     * @NotLogged
     * @param RegisterBindingModel $model
     * @throws \Exception
     */
    public function register(RegisterBindingModel $model)
    {
        if ($model->getPassword() !== $model->getConfirm()) {
            throw new \Exception("Password don't match Confirm Password!", 400);
        }

        if (!preg_match('/^[\w]{3,15}$/', $model->getUsername())) {
            throw new \Exception("Invalid username format!", 400);
        }

        // Check for already registered with the same name
        $this->db->prepare("SELECT id
                                FROM users
                                WHERE username = ?",
            array($model->getUsername()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        if ($id !== null) {
            $username = $model->getUsername();
            throw new \Exception("Username '$username' already taken!", 400);
        }

        // Check for already registered with the same email
        $this->db->prepare("SELECT id
                                FROM users
                                WHERE email = ?",
            array($model->getEmail()));
        $response = $this->db->execute()->fetchRowAssoc();
        $id = $response['id'];
        if ($id !== null) {
            $email = $model->getEmail();
            throw new \Exception("Email '$email' already taken!", 400);
        }

        $this->db->prepare("INSERT
                            INTO users
                            (username, password, email)
                            VALUES (?, ?, ?)",
            array(
                $model->getUsername(),
                $model->getPassword(),
                $model->getEmail()
            )
        )->execute();

        $loginBindingModel = new LoginBindingModel(array('username' => $model->getUsername(), 'password' => $model->getPassword()));
        // Work around to avoid double crypting passwords.
        $loginBindingModel->afterRegisterPasswordPass($model->getPassword());
        $this->login($loginBindingModel);
    }
}