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

    public function delete($model_id){
        $delete = $this->db->prepare("delete from usuarios where id = :id");
        $delete->execute(array(
            ':id' => $model_id,
        ));
        return $this->count($model_id) > 0;
    }

    public function id(){
        $this->db->lastInsertId();
    }

    public function first($model_id){
        $first = $this->db->prepare("select * from usuarios where id = :id");
        $first->execute(array(
            ':id' => $model_id,
        ));
        return $first->fetch(PDO::FETCH_ASSOC);
    }

    public function all(){
        $all = $this->db->query('select * from usuarios order by username asc');

        $return = array();
        while($usuario = $all->fetch(PDO::FETCH_ASSOC)){
            $return[$usuario['id']] = $usuario;
        }
        return $return;
    }

    public function count($model_id){
        $count = $this->first($model_id);
    }
}