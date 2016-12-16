<?php

Class HomeController extends AppController {

    public function __construct(){
        parent::__construct();
        $this->loadModel(array(
            'UsuariosModel' => 'usuarios_model',
        ));
    }

    public function index(){
    }

    public function debug(){
        // $this->UsuariosModel->delete(1);
    }
}