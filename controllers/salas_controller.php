<?php

Class SalasController extends AppController {

    public function __construct(){
        parent::__construct();
        $this->loadModel(array(
            'SalasModel' => 'salas_model',
        ));
    }

    public function index(){
        // route
        $this->action('lista_salas');
    }

    public function lista_salas(){

        $this->vars(array(
            'salas' => $this->SalasModel->all(),
        ));
    }

    public function crud_sala(){
        $salas_id = $this->get['id'];

        if(!empty($this->post)){
            if(!empty($this->post['delete_salas_id'])){
                $this->SalasModel->delete($this->post['delete_salas_id']);
                echo json_encode(array('data'=>true));
            } else

            if(empty($salas_id)){
                $this->SalasModel->insert($this->post);
            } else 

            if(!empty($salas_id)){
                $this->SalasModel->update($salas_id, $this->post);
            }


            if($this->SalasModel->id() > 0){
                // sucesso
                $this->vars(array('message' => 'Sala cadastrada com sucesso.'));
            } else {
                // falha
                $this->vars(array('message' => 'Ocorreu erro ao cadastrar sala.'));
            }

            $this->redirect('/salas');
        }

        $this->vars(array(
            'sala' => $this->SalasModel->first($salas_id),
        ));
    }
}