<?php
namespace Helpers;

class Common {
    public static function toFloat($vl) {
        return (float) str_replace(',', '.', str_replace('.', '', $vl));
    }
    
    static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

     static function ConverteData($Data){

         if (strstr($Data, "/"))//verifica se tem a barra /

         {

           $d = explode ("/", $Data);//tira a barra

           $rstData = "$d[2]-$d[1]-$d[0]";//separa as datas $d[2] = ano $d[1] = mes etc...

           return $rstData;

         } elseif(strstr($Data, "-")){

           $d = explode ("-", $Data);

           $rstData = "$d[2]/$d[1]/$d[0]";

           return $rstData;

         }else{

           return "Data invalida";

         }

    }



    public static function SomarDias($data, $dias, $meses, $ano)

        {

           $data = explode("/", $data);

           $newData = date("d/m/Y", mktime(0, 0, 0, $data[1]  , $data[0] - $dias, $data[2] + $ano) );

           return $newData;

        }





    public static function get_inicio_fim_semana($numero_semana = "", $ano = "")

        {

            $semana_atual = strtotime('+'.$numero_semana.' weeks', strtotime($ano.'0101')); 

            $dia_semana = date('w', $semana_atual);

            $data_inicio_semana = strtotime('-'.$dia_semana.' days', $semana_atual);

            $primeiro_dia_semana = date('Y-m-d', $data_inicio_semana);

            $ultimo_dia_semana = date('Y-m-d', strtotime('+6 days', strtotime($primeiro_dia_semana)));

            return array($primeiro_dia_semana, $ultimo_dia_semana);

        }



    public static function getMaskedDocumento($doc){

        $doc = self::Replace('/[^0-9]/','',$doc);

        return self::Mask($doc,(strlen($doc)>11?'##.###.###/####-##':'###.###.###-##'));

    }



    public static function antiInjection($sql)

    {

        while(preg_match("/('|\*|--|\\\\)/i", $sql)){

            $sql = preg_replace("/('|\*|--|\\\\)/i","",$sql);

        }

        return addslashes(strip_tags(trim($sql)));

    }



    public static function decodeText($text)

    {

        return html_entity_decode(strip_tags($text), ENT_QUOTES, 'ISO-8859-1');

    }





    public static function limitaCaracteres($texto, $limite, $quebra = true){

            $tamanho = strlen($texto);

            if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite

                $novo_texto = $texto;

            }else{ // Se o tamanho do texto for maior que o limite

                if($quebra == true){ // Verifica a opção de quebrar o texto

                $novo_texto = trim(substr($texto, 0, $limite))."...";

            }else{ // Se não, corta $texto na última palavra antes do limite

                $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite

                $novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada

            }

           }

           return $novo_texto; // Retorna o valor formatado

    }



    public static function subText($text, $length)

    {

        if ($length)

        {

            $dec = self::decodeText($text);

            $ret = substr($dec, 0, $length);



            $ret = $ret.(strlen($dec) > $length ? "..." : "");

        }

        else

            $ret = $text;



        return $ret;

    }



    public static function Show($texto, $class="", $return=false, $dismiss=false) {

        if($class != ''){

            $retorno = "<div class=\"alert alert-{$class}\">".($dismiss?"<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>":"")."{$texto}</div>";

            if($return)

                return $retorno;

        }else{

            $retorno = $texto;   

        }

        print($retorno);

            

    }



    public static function friendlyUrl($id, $name){

        $nome = self::Replace('/[ ]/i','-',self::Replace('/[^0-9A-Za-z ]/i','',self::removeDiatrics(strip_tags($name))));

        return $id."/".trim(substr(strtolower($nome),0,50)).".html";

    }



    public static function hotUrl($id, $name) {

        $nome = self::Replace('/[ ]/i','-',self::Replace('/[^0-9A-Za-z ]/i','',self::removeDiatrics(strip_tags($name))));

        return preg_replace('/-+/', '-', trim(substr(strtolower($nome), 0, 80)).'-').$id;

    }



    public static function checkEmail($email) {

        return filter_var($email, FILTER_VALIDATE_EMAIL);

    }



     public static function converteEmail($email) {

        $p = str_split(trim($email));

        $new_mail = '';

        foreach ($p as $val) {

            $new_mail .= '&#'.ord($val).';';

        }

        return $new_mail;

    }



    public static function parseMoney($valor, $precision=2) {

        $valor = str_replace(",",".",$valor);

        return number_format($valor,$precision,",",".");

    }



    public static function redirect($pagina){

        print("<script type=\"text/javascript\"> location='".$pagina."';</script>");

    }



    public static function location($pagina){

        header('Location:'.$pagina);

        exit;

    }



    public static function getFileExtension($file_name) {
        $arr = explode('.',$file_name);
        $extension = end($arr);
        return strtolower($extension);
    }

    
    public static function getFileByCurl($url) {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;

    }






    public static function validaCNPJ($cnpj) {

        $j = 0;

        for ($i = 0; $i < (strlen($cnpj)); $i++) {

            if (is_numeric($cnpj[$i])) {

                $num[$j] = $cnpj[$i];

                $j++;

            }

        }

        //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.

        if (count($num) != 14) {

            $isCnpjValid = false;

        }

        //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.

        if ($num[0] == 0 && $num[1] == 0 && $num[2] == 0 && $num[3] == 0 && $num[4] == 0 && $num[5] == 0 && $num[6] == 0 && $num[7] == 0 && $num[8] == 0 && $num[9] == 0 && $num[10] == 0 && $num[11] == 0) {

            $isCnpjValid = false;

        }

        //Etapa 4: Calcula e compara o primeiro dígito verificador.

        else {

            $j = 5;

            for ($i = 0; $i < 4; $i++) {

                $multiplica[$i] = $num[$i] * $j;

                $j--;

            }

            $soma = array_sum($multiplica);

            $j = 9;

            for ($i = 4; $i < 12; $i++) {

                $multiplica[$i] = $num[$i] * $j;

                $j--;

            }

            $soma = array_sum($multiplica);

            $resto = $soma % 11;

            if ($resto < 2) {

                $dg = 0;

            } else {

                $dg = 11 - $resto;

            }

            if ($dg != $num[12]) {

                $isCnpjValid = false;

            }

        }

        //Etapa 5: Calcula e compara o segundo dígito verificador.

        if (!isset($isCnpjValid)) {

            $j = 6;

            for ($i = 0; $i < 5; $i++) {

                $multiplica[$i] = $num[$i] * $j;

                $j--;

            }

            $soma = array_sum($multiplica);

            $j = 9;

            for ($i = 5; $i < 13; $i++) {

                $multiplica[$i] = $num[$i] * $j;

                $j--;

            }

            $soma = array_sum($multiplica);

            $resto = $soma % 11;

            if ($resto < 2) {

                $dg = 0;

            } else {

                $dg = 11 - $resto;

            }

            if ($dg != $num[13]) {

                $isCnpjValid = false;

            } else {

                $isCnpjValid = true;

            }

        }

        //Trecho usado para depurar erros.

        /*

          if($isCnpjValid==true)

          {

          echo "<p><font color=\"GREEN\">Cnpj é Válido</font></p>";

          }

          if($isCnpjValid==false)

          {

          echo "<p><font color=\"RED\">Cnpj Inválido</font></p>";

          }

         */

        //Etapa 6: Retorna o Resultado em um valor booleano.

        return $isCnpjValid;

    }

    public static function ReArrayFiles($file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }



    public static function removeAcentos($str){

        return self::removeDiatrics($str);

    }



    public static function Replace($regularexp, $to, $string){

        return preg_replace_callback($regularexp, function () use ($to) { return $to; }, $string);

    }



    public static function Mask($val, $mask) {
        $val = self::Replace('/[^0-9]/','', $val);
        $maskared = '';

        $k = 0;

        for ($i = 0; $i <= strlen($mask) - 1; $i++) {

            if ($mask[$i] == '#') {

                if (isset($val[$k]))

                    $maskared .= $val[$k++];

            }

            else {

                if (isset($mask[$i]))

                    $maskared .= $mask[$i];

            }

        }

        return $maskared;

    }





    public static function maskTel($tel){

        $tel = self::Replace('/[^0-9]/','', $tel);

        if($tel != ''){

            return self::Mask($tel,(strlen($tel)>10?'(##) #####-####':'(##) ####-####'));

        }

        return $tel;

    }

    

    public static function getEmbed($link, $width=560,$height=315){

        $defaultVimeo   = '<iframe src="http://player.vimeo.com/video/#ID#?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="#WIDTH#" height="#HEIGHT#" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

        $defaultYoutube = '<iframe width="#WIDTH#" height="#HEIGHT#" src="https://www.youtube.com/embed/#ID#" frameborder="0" allowfullscreen></iframe>';



        if(strpos(strtolower($link),'youtube.com')){

            preg_match('/v=(.{11})|\/v\/(.{11})|\/embed\/(.{11})/i', $link, $matches);

            $id = $matches[1];

            $embed = $defaultYoutube;



        }elseif(strpos(strtolower($link),'vimeo.com')){

            preg_match('/vimeo\.com\/([0-9]{1,10})/i', $link, $matches);

            $id = $matches[1];

            $embed = $defaultVimeo;

        }else{

            $embed = "";

        }



        if($embed!=""){

            $embed = str_replace('#WIDTH#', $width, $embed);

            $embed = str_replace('#HEIGHT#', $height, $embed);

            $embed = str_replace('#ID#', $id, $embed);

        }



        return $embed;

    }



    public static function seems_utf8($str)

    {

        $length = strlen($str);

        for ($i=0; $i < $length; $i++) {

            $c = ord($str[$i]);

            if ($c < 0x80) $n = 0; # 0bbbbbbb

            elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb

            elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb

            elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb

            elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb

            elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b

            else return false; # Does not match any model

            for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?

                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))

                    return false;

            }

        }

        return true;

    }



    /**

     * Converts all accent characters to ASCII characters.

     *

     * If there are no accent characters, then the string given is just returned.

     *

     * @param string $string Text that might have accent characters

     * @return string Filtered string with replaced "nice" characters.

     */

    public static function removeDiatrics($string) {

        if ( !preg_match('/[\x80-\xff]/', $string) )

            return $string;



        if (self::seems_utf8($string)) {

            $chars = array(

            // Decompositions for Latin-1 Supplement

            chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',

            chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',

            chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',

            chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',

            chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',

            chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',

            chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',

            chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',

            chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',

            chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',

            chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',

            chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',

            chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',

            chr(195).chr(159) => 's', chr(195).chr(160) => 'a',

            chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',

            chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',

            chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',

            chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',

            chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',

            chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',

            chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',

            chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',

            chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',

            chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',

            chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',

            chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',

            chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',

            chr(195).chr(191) => 'y',

            // Decompositions for Latin Extended-A

            chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',

            chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',

            chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',

            chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',

            chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',

            chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',

            chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',

            chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',

            chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',

            chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',

            chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',

            chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',

            chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',

            chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',

            chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',

            chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',

            chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',

            chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',

            chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',

            chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',

            chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',

            chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',

            chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',

            chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',

            chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',

            chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',

            chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',

            chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',

            chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',

            chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',

            chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',

            chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',

            chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',

            chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',

            chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',

            chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',

            chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',

            chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',

            chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',

            chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',

            chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',

            chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',

            chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',

            chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',

            chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',

            chr(197).chr(154) => 'S',chr(197).chr(155) => 's',

            chr(197).chr(156) => 'S',chr(197).chr(157) => 's',

            chr(197).chr(158) => 'S',chr(197).chr(159) => 's',

            chr(197).chr(160) => 'S', chr(197).chr(161) => 's',

            chr(197).chr(162) => 'T', chr(197).chr(163) => 't',

            chr(197).chr(164) => 'T', chr(197).chr(165) => 't',

            chr(197).chr(166) => 'T', chr(197).chr(167) => 't',

            chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',

            chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',

            chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',

            chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',

            chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',

            chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',

            chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',

            chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',

            chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',

            chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',

            chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',

            chr(197).chr(190) => 'z', chr(197).chr(191) => 's',

            // Euro Sign

            chr(226).chr(130).chr(172) => 'E',

            // GBP (Pound) Sign

            chr(194).chr(163) => '');



            $string = strtr($string, $chars);

        } else {

            // Assume ISO-8859-1 if not UTF-8

            $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)

                .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)

                .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)

                .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)

                .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)

                .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)

                .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)

                .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)

                .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)

                .chr(252).chr(253).chr(255);



            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";



            $string = strtr($string, $chars['in'], $chars['out']);

            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));

            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');

            $string = str_replace($double_chars['in'], $double_chars['out'], $string);

        }



        return $string;

    }

}

