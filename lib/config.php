<?php

Class Config {
    private $config = array();

    public static function &getInstance() {
        static $instance = array();
        if(!isset($instance[0]) || !$instance[0]){
            $instance[0] = new Config();
        }
        return $instance[0];
    }

    public static function read($key = "") {
        $self = self::getInstance();
        return $self->config[$key];
    }

    public static function write($key = "", $value = "") {
        $self = self::getInstance();
        $self->config[$key] = $value;
        return true;
    }
}