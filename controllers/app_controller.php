<?php

Class AppController {
    protected $get = array(); // variável GET do servidor
    protected $post = array(); // variável POST do formulário
    protected $action; // nome da action usado para renderizar view e suas variáveis
    protected $vars = array(); // variáveis enviadas à view

    public function __construct(){
        // armazena post e get
        $this->get = Mapper::parse();
        $this->post = sanitizeQuotes($_POST);
    }


    /**
     * Permissão de acessos.
     */
    public function filter(){
    }

    /**
     * Renderiza view com informações de variáveis.
     */
    public function render(){
        $view = 'Erro: View '.$filename.' não encontrada.';
        $filename = ROOT.'/views/'.$this->action.'.htm.php';
        if(!empty($this->action) && file_exists($filename)){
            extract($this->vars, EXTR_OVERWRITE);
            ob_start();
            include $filename;
            $view = ob_get_clean();
        }

        $contentForLayout = $view;
        ob_start();
        include ROOT.'/layouts/main.htm.php';
        echo ob_get_clean();
    }

    protected function action($action){
        $this->action = $action;
        $this->{$action}(array());
    }

    public function vars($variables){
        if(!empty($variables)){
            foreach($variables as $name => $value){
                $this->vars[$name] = $value;
            }
        }
    }

    public function loadModel($model, $file=null){
        if(is_array($model)){
            if(!empty($model)){
                foreach($model as $class => $file){
                    $this->loadModel($class, $file);
                }
            }
        } else {
            if(!isset($this->{$model})){
                require ROOT.'/models/'.$file.'.php';
                $this->{$model} = new $model();
            }
        }
    }
}