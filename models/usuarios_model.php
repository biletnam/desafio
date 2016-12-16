<?php

Class UsuariosModel extends AppModel {

    public function insert($data){
        try{
            $insert = $this->db->prepare('INSERT INTO usuarios (username, passwd) VALUES(:username, :passwd)');
            $insert->execute(array(
                ':username' => $data['username'],
                ':passwd' => $data['passwd'],
            ));
        } catch(PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
        }

        return $this->db->lastInsertId() >0;
    }

    public function update($model_id, $data){

    }

    public function delete($model_id, $data){

    }

    public function id(){
        $this->db->lastInsertId();
    }

    public function first($model_id){

    }

    public function all(){
        $all = $this->db->query('select * from usuarios order by username asc');

        $return = array();
        while($usuario = $all->fetch(PDO::FETCH_ASSOC)){
            $return[$usuario['id']] = $usuario;
        }
        return $return;
    }
}