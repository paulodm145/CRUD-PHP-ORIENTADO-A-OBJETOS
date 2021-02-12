<?php
namespace Helpers;
class Data {

    public static function getNomeMes($mes, $lang) {
        if ($lang == "EN") {
            switch ($mes + 0) {
                case 1: $mes_ext = "January";
                    break;
                case 2: $mes_ext = "February";
                    break;
                case 3: $mes_ext = "March";
                    break;
                case 4: $mes_ext = "April";
                    break;
                case 5: $mes_ext = "May";
                    break;
                case 6: $mes_ext = "June";
                    break;
                case 7: $mes_ext = "July";
                    break;
                case 8: $mes_ext = "August";
                    break;
                case 9: $mes_ext = "September";
                    break;
                case 10: $mes_ext = "October";
                    break;
                case 11: $mes_ext = "November";
                    break;
                case 12: $mes_ext = "December";
                    break;
            }
        } else {
            switch ($mes + 0) {
                case 1: $mes_ext = "Janeiro";
                    break;
                case 2: $mes_ext = "Fevereiro";
                    break;
                case 3: $mes_ext = "Mar&ccedil;o";
                    break;
                case 4: $mes_ext = "Abril";
                    break;
                case 5: $mes_ext = "Maio";
                    break;
                case 6: $mes_ext = "Junho";
                    break;
                case 7: $mes_ext = "Julho";
                    break;
                case 8: $mes_ext = "Agosto";
                    break;
                case 9: $mes_ext = "Setembro";
                    break;
                case 10: $mes_ext = "Outubro";
                    break;
                case 11: $mes_ext = "Novembro";
                    break;
                case 12: $mes_ext = "Dezembro";
                    break;
            }
        }
        return $mes_ext;
    }

    public static function getNomeDiaSemana($dia, $lang) {
        if ($lang == "EN") {
            switch ($dia) {
                case "0" : $diaSem = "Sunday";
                    break;
                case "1" : $diaSem = "Monday";
                    break;
                case "2" : $diaSem = "Thursday";
                    break;
                case "3" : $diaSem = "Wednesday";
                    break;
                case "4" : $diaSem = "Tuesday";
                    break;
                case "5" : $diaSem = "Friday";
                    break;
                case "6" : $diaSem = "Saturday";
                    break;
            }
        } else {
            switch ($dia) {
                case "0" : $diaSem = "Domingo";
                    break;
                case "1" : $diaSem = "Segunda-feira";
                    break;
                case "2" : $diaSem = "Terça-feira";
                    break;
                case "3" : $diaSem = "Quarta-feira";
                    break;
                case "4" : $diaSem = "Quinta-feira";
                    break;
                case "5" : $diaSem = "Sexta-feira";
                    break;
                case "6" : $diaSem = "Sábado";
                    break;
            }
        }

        return $diaSem;
    }

    public static function getFormat($data, $formato, $lang = 'PT') {
        if (self::isValid($data)) {
            $regex1 = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})/';
            $regex2 = '/^([0-9]{4})-([0-9]{2})-([0-9]{2})/';
            $arrDate = array(
                'h' => 0,
                'i' => 0,
                's' => 0,
                'd' => 0,
                'm' => 0,
                'y' => 0,
            );
            $pData = explode(" ", $data);
            if (preg_match($regex2, $data)) {
                list($arrDate['y'], $arrDate['m'], $arrDate['d']) = explode('-', $pData[0]);
            } else {
                list($arrDate['d'], $arrDate['m'], $arrDate['y']) = explode('/', $pData[0]);
            }

            if (isset($pData[1])) {
                list($arrDate['h'], $arrDate['i'], $arrDate['s']) = explode(':', $pData[1]);
            }

            $mkDate = mktime($arrDate['h'], $arrDate['i'], $arrDate['s'], $arrDate['m'], $arrDate['d'], $arrDate['y']);

            if (strtolower($formato) == 'extenso') {
                $result = $arrDate['d'] . ' de ' . self::getNomeMes($arrDate['m'], $lang) . ' de ' . $arrDate['y'];
            } elseif (strtolower($formato) == 'completa') {
                $replacement = ($lang != 'EN' ? "%s, %s de %s de %s" : '%s, %s %s %s');
                $result = sprintf($replacement, self::getNomeDiaSemana(date("w", $mkDate), $lang), $arrDate['d'], self::getNomeMes($arrDate['m'], $lang), $arrDate['y']
                );
            } else {
                $result = date($formato, $mkDate);
            }

            return $result;
        } else {
            return 'Invalid date.';
        }
    }

    public static function isValid($data) {
        $regex1 = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})/';
        $regex2 = '/^([0-9]{4})-([0-9]{2})-([0-9]{2})/';
        $arrDate = array(
            'h' => 0,
            'i' => 0,
            's' => 0,
            'd' => 0,
            'm' => 0,
            'y' => 0,
        );
        $pData = explode(" ", $data);
        $test1 = @preg_match($regex1, $data);
        $test2 = @preg_match($regex2, $data);
        if ($test2) {
            list($arrDate['y'], $arrDate['m'], $arrDate['d']) = explode('-', $pData[0]);
        } elseif ($test1) {
            list($arrDate['d'], $arrDate['m'], $arrDate['y']) = explode('/', $pData[0]);
        } else {
            return false;
        }
        return checkdate($arrDate['m'], $arrDate['d'], $arrDate['y']);
    }

    public static function BuscaDataCompleta() {
        switch (date("w")) {
            case "0" : $retorno = "Domingo, ";
                break;
            case "1" : $retorno = "Segunda, ";
                break;
            case "2" : $retorno = "Terça, ";
                break;
            case "3" : $retorno = "Quarta, ";
                break;
            case "4" : $retorno = "Quinta, ";
                break;
            case "5" : $retorno = "Sexta, ";
                break;
            case "6" : $retorno = "Sábado, ";
                break;
        }
        $retorno .= date("d") . " de ";
        switch (date("m")) {
            case "01" : $retorno .= "janeiro";
                break;
            case "02" : $retorno .= "fevereiro";
                break;
            case "03" : $retorno .= "março";
                break;
            case "04" : $retorno .= "abril";
                break;
            case "05" : $retorno .= "maio";
                break;
            case "06" : $retorno .= "junho";
                break;
            case "07" : $retorno .= "julho";
                break;
            case "08" : $retorno .= "agosto";
                break;
            case "09" : $retorno .= "setembro";
                break;
            case "10" : $retorno .= "outubro";
                break;
            case "11" : $retorno .= "novembro";
                break;
            case "12" : $retorno .= "dezembro";
                break;
        }
        return $retorno . " de " . date("Y");
    }

    public static function RemontaData($data, $separadores, $entrada, $saida) {

        $arrEnt = explode($separadores, $entrada);
        $arrDat = explode($separadores, $data);

        $dtMod = array($arrEnt[0] => $arrDat[0], $arrEnt[1] => $arrDat[1], $arrEnt[2] => $arrDat[2]);

        $newDate = str_replace($arrEnt[0], $dtMod[$arrEnt[0]], $saida);
        $newDate = str_replace($arrEnt[1], $dtMod[$arrEnt[1]], $newDate);
        $newDate = str_replace($arrEnt[2], $dtMod[$arrEnt[2]], $newDate);

        return $newDate;
    }

}
