<?php

Class SalasModel extends AppModel {

    public function insert($data){
        try{
            $insert = $this->db->prepare('INSERT INTO salas (nome, capacidade, datashow, observacoes) VALUES (:nome, :capacidade, :datashow, :observacoes)');
            $insert->bindValue(':nome', $data['nome'], PDO::PARAM_STR);
            $insert->bindValue(':capacidade', $data['capacidade'], PDO::PARAM_INT);
            $insert->bindValue(':datashow', $data['datashow'], PDO::PARAM_BOOL);
            $insert->bindValue(':observacoes', $data['observacoes'], PDO::PARAM_STR);
            $insert->execute();
        } catch(PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
        }

        return $this->db->lastInsertId() >0;
    }

    public function update($model_id, $data){
        try{
            $update = $this->db->prepare('UPDATE salas set nome = :nome, capacidade = :capacidade, datashow = :datashow, observacoes = :observacoes where id = :id');
            $update->bindValue(':id', $model_id, PDO::PARAM_INT);
            $update->bindValue(':nome', $data['nome'], PDO::PARAM_STR);
            $update->bindValue(':capacidade', $data['capacidade'], PDO::PARAM_INT);
            $update->bindValue(':datashow', $data['datashow'], PDO::PARAM_BOOL);
            $update->bindValue(':observacoes', $data['observacoes'], PDO::PARAM_STR);
            $update->execute();
        } catch(PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
        }

        return $this->db->lastInsertId() >0;
    }

    public function delete($model_id){
        $this->loadModel('ReservasModel', 'reservas_model');

        $excluiu = false;

        if($this->ReservasModel->countBySalasId($model_id) >0){
            $this->ReservasModel->deleteBySalasId($model_id);
        }

        $delete = $this->db->prepare("DELETE from salas where id = :id");
        $delete->execute(array(
            ':id' => $model_id,
        ));
        $excluiu = $this->db->lastInsertId() > 0;

        return $excluiu;
    }

    public function id(){
        $this->db->lastInsertId();
    }

    public function first($model_id){
        $first = $this->db->prepare("SELECT * from salas where id = :id");
        $first->execute(array(
            ':id' => $model_id,
        ));
        return $first->fetch(PDO::FETCH_ASSOC);
    }

    public function all(){
        $all = $this->db->query('SELECT * from salas order by nome asc, capacidade asc');

        $return = array();
        while($sala = $all->fetch(PDO::FETCH_ASSOC)){
            $return[$sala['id']] = $sala;
        }
        return $return;
    }

    public function count($model_id){
        $count = $this->first($model_id);
    }
}