<?php

Class ReservasController extends AppController {

    public function __construct(){
        parent::__construct();
        $this->loadModel(array(
            'SalasModel' => 'salas_model',
            'UsuariosModel' => 'usuarios_model',
            'ReservasModel' => 'reservas_model',
            'LoginModel' => 'login_model',
        ));
    }

    public function index(){
        
        $this->action('lista_reservas');
    }

    public function lista_reservas(){

        $this->vars(array(
            'salas' => $this->SalasModel->all(),
            'reservas' => $this->ReservasModel->all(),
        ));
// die(debug($this->vars['reservas']));
    }

    public function crud(){
        $reservas_id = $this->get['id'];
        $hora = $this->get['named']['hora'];
        $salas_id = $this->get['named']['sala'];
        $usuario = $this->LoginModel->user();

        if(!empty($reservas_id)){
            $this->ReservasModel->delete($reservas_id);
        } else

        if(empty($reservas_id)){
            $this->ReservasModel->insert($salas_id, $hora, $usuario['id']);
        }

        $this->redirect('/reservas');
    }
}