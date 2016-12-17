<?php

function sanitizeQuotes($conteudo){
    if(is_array($conteudo)){
        // From PHP Manual: http://www.php.net/manual/en/function.get-magic-quotes-gpc.php#97783
        // Create lamba style unescaping function (for portability)
        $quotes_sybase = strtolower(ini_get('magic_quotes_sybase'));
        $unescape_function = (empty($quotes_sybase) || $quotes_sybase === 'off') ? 'stripslashes($value)' : 'str_replace("\'\'","\'",$value)';
        $stripslashes_deep = create_function('&$value, $fn', '
            if (is_string($value)) {
                $value = ' . $unescape_function . ';
            } else if (is_array($value)) {
                foreach ($value as &$v) $fn($v, $fn);
            }
        ');
        $stripslashes_deep($conteudo,$stripslashes_deep);
    } else {
        $conteudo = stripslashes($conteudo);
    }
    return $conteudo;
}

function debug(){
    $argumentos = func_get_args();
    ob_start();
    call_user_func_array('var_dump', $argumentos);
    $debug = ob_get_clean();
    echo '<pre>'.$debug.'</pre>';
}

function str_zero($n,$casas,$inverso=false){
    if( $inverso && is_numeric($n) && $n>0 ){
        while( substr($n,0,1)=='0' ){
            $n = substr($n,1);
        }
        return $n;
    }
    $result = str_pad($n, $casas, "0", STR_PAD_LEFT);
    return $result;
}