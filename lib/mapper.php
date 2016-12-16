<?php

class Mapper {
    /**
     *  Definições de prefixos.
     */
    public $prefixes = array();
    /**
     *  Definição de rotas.
     */
    public $routes = array();
    /**
     *  URL atual da aplicação.
     */
    private $here = null;
    /**
     *  URL base da aplicação.
     */
    private $base = null;
    /**
     *  Controller padrão da aplicação.
     */
    public $root = null;

    /**
     *  Define a URL base e URL atual da aplicação.
     */
    public function __construct() {
        if(is_null($this->base)){
            $this->base = dirname($_SERVER["PHP_SELF"]);
            while(in_array(basename($this->base), array("public"))){
                $this->base = dirname($this->base);
            }
            if($this->base == DS || $this->base == "."){
                $this->base = "/";
            }
        }
        if(is_null($this->here)){
            $start = strlen($this->base);
            $this->here = self::normalize(substr($_SERVER["REQUEST_URI"], $start));
        }
    }
    public static function &getInstance() {
        static $instance = array();
        if(!isset($instance[0]) || !$instance[0]){
            $instance[0] = new Mapper();
        }
        return $instance[0];
    }
    /**
     *  Getter para Mapper::here.
     *
     *  @return string Valor de Mapper:here
     */
    public static function here() {
        $self = self::getInstance();
        return $self->here;
    }
    /**
     *  Getter para Mapper::base.
     *
     *  @return string Valor de Mapper::base
     */
    public static function base() {
        $self = self::getInstance();
        return $self->base;
    }
    /**
     *  Normaliza uma URL, removendo barras duplicadas ou no final de strings e
     *  adicionando uma barra inicial quando necessário.
     *
     *  @param string $url URL a ser normalizada
     *  @return string URL normalizada
     */
    public static function normalize($url) {
        if(preg_match("/^[a-z]+:/", $url)){
            return $url;
        }
        $url = "/" . $url;
        while(strpos($url, "//") !== false){
            $url = str_replace("//", "/", $url);
        }
        $url = rtrim($url, "/");
        if(empty($url)){
            $url = "/";
        }
        return $url;
    }
    /**
     *  Conecta uma URL a uma rota do framework.
     *
     *  @param string $url URL a ser conectada
     *  @param string $route Rota para a qual a URL será direcionada
     *  @return true
     */
    public static function connect($url = null, $route = null) {
        if(is_array($url)){
            foreach($url as $key => $value){
                self::connect($key, $value);
            }
        } else if(!is_null($url)){
            $self = self::getInstance();
            $url = self::normalize($url);
            $self->routes[$url] = rtrim($route, "/");
        }
        return true;
    }
    /**
     *  Verifica se uma URL é equivalente a outra.
     *
     *  @param string $check URL a ser checada
     *  @param string $url URL que checará a primeira
     *  @return boolean Verdadeiro se as URLs são correspondentes
     */
    public static function match($check, $url = null) {
        if(is_null($url)){
            $url = self::here();
        }
        $check = "%^" . str_replace(array(":any", ":fragment", ":num"), array("(.+)", "([^\/]+)", "([0-9]+)"), $check) . "/?$%";
        return preg_match($check, $url);
    }
    /**
     *  Retorna a rota correspondente a uma URL.
     *
     *  @param string $url URL a ser convertida para uma rota
     *  @return string Rota para a URL provida
     */
    public static function getRoute($url) {
        $self = self::getInstance();
        foreach($self->routes as $map => $route){
            if(self::match($map, $url)){
                $map = "%^" . str_replace(array(":any", ":fragment", ":num"), array("(.+)", "([^\/]+)", "([0-9]+)"), $map) . "/?$%";
                $url = preg_replace($map, $route, $url);
                break;
            }
        }
        return self::normalize($url);
    }
    /**
     *  Faz a interpretação da URL, identificando as partes da URL.
     * 
     *  @param string $url URL a ser interpretada
     *  @return array URL interpretada
     */
    public static function parse($url = null, $debug=false) {
        $here = self::normalize(is_null($url) ? self::here() : $url);
        $url = self::getRoute($here);
        $prefixes = join("|", array('admin|api'));
        
        $path = array();
        $parts = array("here", "prefix", "controller", "action", "id", "extension", "params", "queryString");
        preg_match("/^\/(?:({$prefixes})(?:\/|(?!\w)))?(?:([a-z0-9_-]*)\/?)?(?:([a-z0-9_-]*)\/?)?(?:(\d*))?(?:\.([\w]+))?(?:\/?([^?]+))?(?:\?(.*))?/i", $url, $reg);
        foreach($parts as $k => $key){
            $path[$key] = isset($reg[$k]) ? $reg[$k] : null;
        }
        
        if(is_numeric($path['action'])){
            $id = $path['action'];
            $path['action'] = 'index';
            $path['id'] = $id;
        }

        $path["named"] = $path["params"] = array();
        if(isset($reg[6])){
            foreach(explode("/", $reg[6]) as $param){
                if(preg_match("/([^:]*):([^:]*)/", $param, $reg)){
                    $path["named"][$reg[1]] = urldecode($reg[2]);
                } elseif($param != ""){
                    $path["params"] []= urldecode($param);
                }
            }
        }

        $path["here"] = $here;
        if(empty($path["controller"])) $path["controller"] = self::getRoot();
        if(empty($path["action"])) $path["action"] = "index";
        if($filtered = self::filterAction($path["action"])){
            $path["prefix"] = $filtered["prefix"];
            $path["action"] = $filtered["action"];
        }
        if(!empty($path["prefix"])){
            $path["action"] = "{$path['prefix']}_{$path['action']}";
        }
        if(empty($path["id"])) $path["id"] = null;
        if(empty($path["extension"])) $path["extension"] = Config::read("defaultExtension");
        if(!empty($path["queryString"])){
            parse_str($path["queryString"], $queryString);
            $path["named"] = array_merge($path["named"], $queryString);
        }
        $path['action'] = Inflector::hyphenToUnderscore($path['action']);

        return $path;
    }
    /**
     *  Gera uma URL, levando em consideração o local atual da aplicação.
     *
     *  @param string $path Caminho relativo ou URL absoluta
     *  @param bool $full Verdadeiro para gerar uma URL completa
     *  @return string URL gerada para a aplicação
     */
    public static function url($path, $full = false) {
        if(is_array($path)){
            $here = self::parse();
            $params = $here["named"];
            $path = array_merge(array(
                "prefix" => $here["prefix"],
                "controller" => $here["controller"],
                "action" => $here["action"],
                "id" => $here["id"]
            ), $params, $path);

            $nonParams = array("prefix", "controller", "action", "id");
            $url = "";
            foreach($path as $key => $value){
                if(!in_array($key, $nonParams)){
                    $url .= "/" . "{$key}:{$value}";
                } else if(!is_null($value)){
                    if($key == "action" && $filtered = self::filterAction($value)){
                        $value = $filtered["action"];
                    }
                    $url .= "/" . $value;
                }
            }
            $url = self::normalize(self::base() . $url);
        } else {
            if(preg_match("/^[a-z]+:/", $path)){
                return $path;
            } else if(substr($path, 0, 1) == "/"){
                $url = self::base() . $path;
            } else if(substr($path, 0, 1) != "#"){
                $url = self::base() . self::here() . $path;
            } else {
                $url = self::base() . self::here() . "/" . $path;
            }
            $url = self::normalize($url);
        }
        return $full ? BASE_URL . $url : $url;
    }
    /**
      *  Filtra uma action, removendo prefixos.
      *
      *  @param string $action Nome da action a ser filtrada
      *  @return mixed Array contendo prefixo e action, falso caso a action não
      *                contenha prefixos
      */
    public static function filterAction($action) {
        if(strpos($action, "_") !== false){
            foreach(self::getPrefixes() as $prefix){
                if(strpos($action, $prefix) === 0){
                    return array(
                        "action" => substr($action, strlen($prefix) + 1),
                        "prefix" => $prefix
                    );
                }
            }
        }
        return false;
    }
}