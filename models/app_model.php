<?php

require ROOT.'/config/database.php';

Class AppModel extends Object {
    protected $db; // objeto PDO

    public function __construct(){
        $this->config = Config::read('database');
        $this->db = new PDO('mysql:host='.$this->config["host"].';dbname='.$this->config["database"].';charset=utf8mb4', $this->config["user"], $this->config["password"]);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}