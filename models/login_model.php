<?php

Class LoginModel extends AppModel {

    public function auth($auth){
        $this->loadModel('UsuariosModel', 'usuarios_model');

        $user = $this->UsuariosModel->firstByUsername($auth['username']);
        if(!empty($user) && $user['passwd'] == $auth['passwd']){
            $_SESSION['auth'] = array(
                'username' => $auth['username'],
                'passwd' => $auth['passwd'],
            );
            return true;
        }

        return false;
    }

    public function loggedIn(){
        if(empty($_SESSION) || empty($_SESSION['auth'])){
            return false;
        }

        $this->loadModel('UsuariosModel', 'usuarios_model');

        $user = $this->UsuariosModel->firstByUsername($_SESSION['auth']['username']);
        return !empty($user) && $user['passwd'] == $_SESSION['auth']['passwd'];
    }

    public function logout(){
        $_SESSION['auth'] = array();
        $_SESSION['previousAction'] = '';
    }

    public function previousAction($action){
        $_SESSION['previousAction'] = $action;
    }

    public function getPreviousAction(){
        return $_SESSION['previousAction'];
    }
}