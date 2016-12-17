<?php

Class HomeController extends AppController {

    public function __construct(){
        parent::__construct();
        $this->loadModel(array(
            'LoginModel' => 'login_model',
            'UsuariosModel' => 'usuarios_model',
        ));
    }

    public function index(){
        // dashboard
    }

    public function login(){
        if(!empty($this->post)){
            if(!$this->LoginModel->auth($this->post)){
                $this->vars(array(
                    'erro_login' => true,
                ));
            } else {
                $this->redirect($this->LoginModel->getPreviousAction());
            }
        }
    }

    public function logout(){
        $this->LoginModel->logout();
        $this->redirect('/');
    }

    public function debug(){
    }
}