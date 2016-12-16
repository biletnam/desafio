<?php

Class Object {

    public function loadModel($model, $file=null){
        if(is_array($model)){
            if(!empty($model)){
                foreach($model as $class => $file){
                    $this->loadModel($class, $file);
                }
            }
        } else {
            if(!isset($this->{$model})){
                require_once ROOT.'/models/'.$file.'.php';
                $this->{$model} = new $model();
            }
        }
    }
}