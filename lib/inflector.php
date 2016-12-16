<?php

class Inflector {
    /**
     *  Transforma uma string para o formato camelizado. Ex.: a-casa-amarela => aCasaAmarela
     *
     *  @param string $string String de entrada
     *  @return string String de saí­da
     */
    public static function camelize($string = "") {
        return str_replace(" ", "", ucwords(str_replace(array("_", "-"), " ", $string)));
    }
    /**
     * Transforma uma string de formato camelizado para formato underscore. Ex.: aCasaAmarela => a_casa_amarela
     * 
     * @param string $string String a ser formatada.
     * @return string String em formato underscore.
     */
    public static function camelcaseToUnderscore($string){
        return strtolower(preg_replace( '/([a-z0-9])([A-Z])/', "$1_$2", $string ));
    }
    /**
     * Transforma uma string de formato camelizado para formato slug. Ex.: aCasaAmarela => a-casa-amarela
     *
     * @param string $string String a ser formatada.
     * @return string String em formato slug.
     */
    public static function camelcaseToSlug($string){
        return strtolower(preg_replace( '/([a-z0-9])([A-Z])/', "$1-$2", $string ));
    }
    /**
     * Transforma uma string de formato camelizado para formato humanizado. Ex.: aCasaAmarela => A Casa Amarela
     *
     * @param string $string String a ser formatada.
     * @return string String em formato slug.
     */
    public static function camelcaseToHumanize($string){
        return self::humanize(self::camelcaseToSlug($string));
    }
    /**
     *  Transforma uma string para o formato humanizado. Ex.: a-casa-amarela => A Casa Amarela
     *
     *  @param string $string String de entrada
     *  @return string String de saída
     */
    public static function humanize($string = "") {
        return ucwords(str_replace(array("_", "-"), " ", $string));
    }
    /**
     *  Substitui os espaços de uma string pelo "_" e converte as letras para caixa-baixa.
     *  Ex.: A Casa Amarela => a_casa_amarela
     *
     *  @param string $string String de entrada
     *  @return strign String de saí­da
     */
    public static function underscore($string = "") {
        return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', str_replace(' ','',$string)));
    }
    /**
     *  Substitui os espaços de uma string pelo "-" e converte as letras para caixa-baixa.
     *  Ex.: A Casa Amarela => a-casa-amarela
     *  
     *  @param string $string String a ser formatada.
     *  @return string Formato em hífen.
     */
    public static function hyphen($string = "") {
        return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '-\\1', str_replace(' ','',$string)));
    }
    /**
     *  Transforma uma string no formato slug, em caixa-baixa, com espaços substituí­dos
     *  por hífens, com a remocao de caracteres acentuados e especiais, deixando
     *  apenas letras minúsculas.
     *
     *  @param string $string String de entrada
     *  @param string $replace String para substituição do espaço
     *  @return string String de saí­da
     *
     *  Adicionado conversão de codificação para compatibilidade.
     *
     */
    public static function slug($string = "", $replace = "-") {
        $old_string = $string;
        // $string = mb_convert_encoding($string,'UTF-8','ISO-8859-1');
        $map = array(
            "/Ã|Ã |Ã|Ã¡|Ã¥|Ã|Ã¢|Ã|Ã£/" => "a",
            "/Ã|Ã¨|Ã|Ã©|Ãª|Ãª|áº½|Ã|Ã«/" => "e",
            "/Ã|Ã¬|Ã|Ã­|Ã|Ã®/" => "i",
            "/Ã|Ã²|Ã|Ã³|Ã|Ã´|Ã¸|Ã|Ãµ/" => "o",
            "/Ã|Ã¹|Ã|Ãº|Å¯|Ã|Ã»|Ã|Ã¼/" => "u",
            "/Ã§|Ã/" => "c",
            "/Ã±|Ã/" => "n",
            "/Ã¤|Ã¦/" => "ae",
            "/Ã|Ã¶/" => "oe",
            "/Ã|Ã¤/" => "Ae",
            "/Ã/" => "Oe",
            "/Ã/" => "ss",
            "/[^\w\s]/" => " ",
            "/\\s+/" => $replace,
            "/^{$replace}+|{$replace}+$/" => ""
        );
        $resultado = strtolower(preg_replace(array_keys($map), array_values($map), $string));
        // return mb_convert_encoding($resultado,'ISO-8859-1','UTF-8');
        return $resultado;
    }
    /**
     *  Substitui o hí­fens "-" na string pelo caractere underscore "_".
     *
     *  @param string $string String de entrada
     *  @return string String de saída
     */
    public static function hyphenToUnderscore($string = "") {
        return str_replace("-", "_", $string);
    }
    /**
     *  Substitui o underscore "_" na string pelo caractere hí­fens "-".
     *  
     *  @param string $string String para formatação.
     *  @return string String formatada.
     */
    public static function underscoreToHyphen($string = ""){
        return str_replace("_","-",$string);
    }
    /**
     * Classe criada por http://goncin.wordpress.com, em
     * http://goncin.wordpress.com/2010/12/16/normalizando-nomes-proprios-com-php/
     * 
     * Constantes definidas para melhor legibilidade do código. O prefixo NN_ indica que
     * seu uso está relacionado ao método público e estático normalizarNome().
     */
    const NN_PONTO = '\.';
    const NN_PONTO_ESPACO = '. ';
    const NN_ESPACO = ' ';
    const NN_REGEX_MULTIPLOS_ESPACOS = '\s+';
    const NN_REGEX_NUMERO_ROMANO = '^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$';

    /**
     * Normaliza o nome próprio dado, aplicando a capitalização correta de acordo
     * com as regras e exceções definidas no código.
     * POR UMA DECISÃO DE PROJETO, FORAM UTILIZADAS FUNÇÕES MULTIBYTE (MB_) SEMPRE
     * QUE POSSÍVEL, PARA GARANTIR SUA USABILIDADE EM STRINGS UNICODE.
     * @param string $nome O nome a ser normalizado
     * @return string O nome devidamente normalizado
     */
    public static function normalizarNome($nome) {

        /*
         * A primeira tarefa da normalização é lidar com partes do nome que
         * porventura estejam abreviadas,considerando-se para tanto a existência de
         * pontos finais (p. ex. JOÃO A. DA SILVA, onde "A." é uma parte abreviada).
         * Dado que mais à frente dividiremos o nome em partes tomando em
         * consideração o caracter de espaço (" "), precisamos garantir que haja um
         * espaço após o ponto. Fazemos isso substituindo todas as ocorrências do
         * ponto por uma sequência de ponto e espaço.
         */
        $nome = mb_ereg_replace(self::NN_PONTO, self::NN_PONTO_ESPACO, $nome);

        /*
         * O procedimento anterior, ou mesmo a digitação errônea, podem ter
         * introduzido espaços múltiplos entre as partes do nome, o que é totalmente
         * indesejado. Para corrigir essa questão, utilizamos uma substituição
         * baseada em expressão regular, a qual trocará todas as ocorrências de
         * espaços múltiplos por espaços simples.
         */
        $nome = mb_ereg_replace(self::NN_REGEX_MULTIPLOS_ESPACOS, self::NN_ESPACO, $nome);

        /*
         * Isso feito, podemos fazer a capitalização "bruta", deixando cada parte do
         * nome com a primeira letra maiúscula e as demais minúsculas. Assim,
         * JOÃO DA SILVA => João Da Silva.
         */
//        $nome = mb_convert_case($nome, MB_CASE_TITLE, mb_detect_encoding($nome));
        $nome = ucwords(strtolower($nome));

        /*
         * Nesse ponto, dividimos o nome em partes, para trabalhar com cada uma
         * delas separadamente.
         */
        $partesNome = mb_split(self::NN_ESPACO, $nome);

        /*
         * A seguir, são definidas as exceções à regra de capitalização. Como
         * sabemos, alguns conectivos e preposições da língua portuguesa e de outras
         * línguas jamais são utilizadas com a primeira letra maiúscula.
         * Essa lista de exceções baseia-se na minha experiência pessoal, e pode ser
         * adaptada, expandida ou mesmo reduzida conforme as necessidades de cada
         * caso.
         */
        $excecoes = array(
          'de', 'di', 'do', 'da', 'dos', 'das', 'dello', 'della',
          'dalla', 'dal', 'del', 'e', 'em', 'na', 'no', 'nas', 'nos', 'van', 'von',
          'y'
        );

        for($i = 0; $i < count($partesNome); ++$i) {

            /*
            * Verificamos cada parte do nome contra a lista de exceções. Caso haja
            * correspondência, a parte do nome em questão é convertida para letras
            * minúsculas.
            */
            foreach($excecoes as $excecao){
                if(mb_strtolower($partesNome[$i]) == mb_strtolower($excecao)){
                    $partesNome[$i] = $excecao;
                }
            }

            /*
            * Uma situação rara em nomes de pessoas, mas bastante comum em nomes de
            * logradouros, é a presença de numerais romanos, os quais, como é sabido,
            * são utilizados em letras MAIÚSCULAS.
            * No site
            * http://htmlcoderhelper.com/how-do-you-match-only-valid-roman-numerals-with-a-regular-expression/,
            * encontrei uma expressão regular para a identificação dos ditos
            * numerais. Com isso, basta testar se há uma correspondência e, em caso
            * positivo, passar a parte do nome para MAIÚSCULAS. Assim, o que antes
            * era "Av. Papa João Xxiii" passa para "Av. Papa João XXIII".
            */
            if(mb_ereg_match(self::NN_REGEX_NUMERO_ROMANO,mb_strtoupper($partesNome[$i]))){
                $partesNome[$i] = mb_strtoupper($partesNome[$i]);
            }
        }

        /*
         * Finalmente, basta juntar novamente todas as partes do nome, colocando um
         * espaço entre elas.
         */
        return implode(self::NN_ESPACO, $partesNome);
    }
}