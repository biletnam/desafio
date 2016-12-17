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
            'usuario_logado' => $this->LoginModel->user(),
            'salas' => $this->SalasModel->all(),
            'reservas' => $this->ReservasModel->all(),
            'erro_message' => $this->get['named']['erro'] == 1? 'você não tem permissão para excluir esta reserva' : '',
        ));
    }

    public function crud(){
        $reservas_id = $this->get['id'];
        $hora = $this->get['named']['hora'];
        $salas_id = $this->get['named']['sala'];
        $usuario = $this->LoginModel->user();

        if(!empty($reservas_id)){
            // verifica se usuário logado tem permissão para excluir
            $usuario_logado = $this->LoginModel->user();
            $reserva = $this->ReservasModel->first($reservas_id);
            if($usuario_logado['id'] == $reserva['usuarios_id']){
                $this->ReservasModel->delete($reservas_id);
            } else {
                $this->redirect('/reservas?erro=1');
            }
            
        } else

        if(empty($reservas_id)){
            $this->ReservasModel->insert($salas_id, $hora, $usuario['id']);
        }

        $this->redirect('/reservas');
    }
}