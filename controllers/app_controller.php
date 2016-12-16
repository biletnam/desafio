<?php

Class AppController {
    protected $get = array(); // variável GET do servidor
    protected $post = array(); // variável POST do formulário
    protected $action; // nome da action usado para renderizar view e suas variáveis
    protected $vars = array(); // variáveis enviadas à view

    public function __construct($get = array(), $post = array()){
        // armazena post e get
        $this->get = empty($get) ? Mapper::parse() : $get;
        $this->post = empty($post) ? sanitizeQuotes($_POST) : $post;
    }


    public function run(){
        $this->filter();

        $controller_name = (!empty($this->get['controller']) ? $this->get['controller'] : 'home') . '_controller';
        $controller = Inflector::camelize($controller_name);
        $this->action = !empty($this->get['action']) ? $this->get['action'] : 'index';

        $filename_controller = ROOT.'/controllers/'.$controller_name.'.php';
        if(!file_exists($filename_controller)){
            $this->action('pagina_nao_existe');
            $this->render();
        } else {
            require_once $filename_controller;
            $Controller = new $controller($this->get, $this->post);
            $Controller->action($this->action);
            $Controller->filter();
            $Controller->{$this->action}();
            $Controller->render();
        }
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
        $filename = ROOT.'/views/'.$this->action.'.htm.php';
        $view = 'Erro: View '.$this->action.' não encontrada.';
        if(!empty($this->action) && file_exists($filename)){
            extract($this->vars, EXTR_OVERWRITE);
            ob_start();
            include $filename;
            $view = ob_get_clean();
        }

        $get = $this->get;
        $contentForLayout = $view;
        ob_start();
        include ROOT.'/layouts/main.htm.php';
        echo ob_get_clean();
    }

    public function action($action){
        $this->action = $action;

        if(!method_exists($this, $action)){
            $this->action = 'pagina_nao_existe';
        }

        $this->{$this->action}(array());
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
                require_once ROOT.'/models/'.$file.'.php';
                $this->{$model} = new $model();
            }
        }
    }

    public function redirect($url){
        if(!headers_sent() && !empty($url)){
            header("Location: " . Mapper::url($url, true));
        }
        exit;
    }


    public function pagina_nao_existe(){
    }
}