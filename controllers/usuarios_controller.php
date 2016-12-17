<?php

Class UsuariosController extends AppController {

    public function __construct(){
        parent::__construct();
        $this->loadModel(array(
            'UsuariosModel' => 'usuarios_model',
        ));
    }

    public function index(){
        // route
        $this->action('lista_usuarios');
    }

    public function lista_usuarios(){

        $this->vars(array(
            'usuarios' => $this->UsuariosModel->all(),
        ));
    }

    public function crud_usuario(){
        $usuarios_id = $this->get['id'];

        if(!empty($this->post)){
            if(!empty($this->post['delete_usuarios_id'])){
                $this->UsuariosModel->delete($this->post['delete_usuarios_id']);
                echo json_encode(array('data'=>true));
            } else

            if(empty($usuarios_id)){
                $this->UsuariosModel->insert($this->post);
            } else 

            if(!empty($usuarios_id)){
                $this->UsuariosModel->update($usuarios_id, $this->post);
            }


            if($this->UsuariosModel->id() > 0){
                // sucesso
                $this->vars(array('message' => 'Usuário cadastrado com sucesso.'));
            } else {
                // falha
                $this->vars(array('message' => 'Ocorreu erro ao cadastrar usuário.'));
            }

            $this->redirect('/usuarios');
        }

        $this->vars(array(
            'usuario' => $this->UsuariosModel->first($usuarios_id),
        ));
    }
}