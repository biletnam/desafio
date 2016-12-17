<?php

Class ReservasModel extends AppModel {

    public function insert($salas_id, $hora, $usuarios_id){
        // valida duplicação de reserva
        $valida3 = $this->db->prepare("SELECT count(*) from reservas where salas_id = :salas_id and hora = :hora and usuarios_id = :usuarios_id");
        $valida3->execute(array(
            ':usuarios_id' => $usuarios_id,
            ':salas_id' => $salas_id,
            ':hora' => $hora,
        ));
        if($valida3->fetchColumn() >0){
            $this->setError('ErroReservaJaExiste', 'Você já possui reserva para esta sala neste horário.');
            return false;
        }

        // valida reserva para mesmo usuário e horário, mas sala diferente
        $valida1 = $this->db->prepare("SELECT count(*) from reservas where usuarios_id = :usuarios_id and hora = :hora");
        $valida1->execute(array(
            ':usuarios_id' => $usuarios_id,
            ':hora' => $hora,
        ));
        if($valida1->fetchColumn() >0){
            $this->setError('ErroUsuarioHorarioMarcado', 'Você não pode marcar outra sala com mesmo horário.');
            return false;
        }
 
        // valida reserva pra horário, sala e usuário já reservado
        $valida2 = $this->db->prepare("SELECT count(*) from reservas where salas_id = :salas_id and hora = :hora");
        $valida2->execute(array(
            ':salas_id' => $salas_id,
            ':hora' => $hora,
        ));
        if($valida2->fetchColumn() >0){
            $this->setError('ErroReservaJaExiste', 'Já existe uma reserva para este horário e sala.');
            return false;
        }
 
        try{
            $insert = $this->db->prepare('INSERT INTO reservas (salas_id, usuarios_id, hora) VALUES (:salas_id, :usuarios_id, :hora)');
            $insert->execute(array(
                ':salas_id' => $salas_id,
                ':usuarios_id' => $usuarios_id,
                ':hora' => str_zero($hora, 2).':00',
            ));
        } catch(PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
        }

        return $this->db->lastInsertId() >0;
    }

    public function update($model_id, $data){
        try{
            $update = $this->db->prepare('UPDATE reservas set salas_id = :salas_id, usuarios_id = :usuarios_id, hora = :hora where id = :id');
            $update->bindValue(':id', $model_id, PDO::PARAM_INT);
            $update->bindValue(':salas_id', $data['salas_id'], PDO::PARAM_INT);
            $update->bindValue(':usuarios_id', $data['usuarios_id'], PDO::PARAM_INT);
            $update->bindValue(':hora', $data['hora'], PDO::PARAM_STR);
            $update->execute();
        } catch(PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
        }

        return $this->db->lastInsertId() >0;
    }

    public function delete($model_id){
        $delete = $this->db->prepare("DELETE from reservas where id = :id");
        $delete->execute(array(
            ':id' => $model_id,
        ));
        return $this->count($model_id) > 0;
    }

    public function deleteByUsuariosId($usuarios_id){
        $delete = $this->db->prepare("DELETE from reservas where usuarios_id = :usuarios_id");
        $delete->execute(array(
            ':usuarios_id' => $usuarios_id,
        ));
        return $this->db->lastInsertId() >0;
    }

    public function deleteBySalasId($salas_id){
        $delete = $this->db->prepare("DELETE from reservas where salas_id = :salas_id");
        $delete->execute(array(
            ':salas_id' => $salas_id,
        ));
        return $this->db->lastInsertId() >0;
    }

    public function id(){
        $this->db->lastInsertId();
    }

    public function first($model_id){
        $first = $this->db->prepare("SELECT * from reservas where id = :id");
        $first->execute(array(
            ':id' => $model_id,
        ));
        return $first->fetch(PDO::FETCH_ASSOC);
    }

    public function all(){
        $all = $this->db->query('SELECT * from reservas order by hora asc');

        $this->loadModel('UsuariosModel', 'usuarios_model');

        $return = array();
        while($reserva = $all->fetch(PDO::FETCH_ASSOC)){
            $return[$reserva['hora']][$reserva['salas_id']] = $reserva;
            $return[$reserva['hora']][$reserva['salas_id']]['usuario'] = $this->UsuariosModel->first($reserva['usuarios_id']);
        }
        return $return;
    }

    public function count($model_id){
        $count = $this->first($model_id);
    }

    public function countByUsuariosId($usuarios_id){
        $count = $this->db->prepare("SELECT count(*) from reservas where usuarios_id = :usuarios_id");
        $count->execute(array(
            ':usuarios_id' => $usuarios_id,
        ));
        return $count->fetchColumn();
    }

    public function countBySalasId($salas_id){
        $count = $this->db->prepare("SELECT count(*) from reservas where salas_id = :salas_id");
        $count->execute(array(
            ':salas_id' => $salas_id,
        ));
        return $count->fetchColumn();
    }
}