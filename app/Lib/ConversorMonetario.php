<?php

namespace App\Lib;

class ConversorMonetario
{

    public static function dolarParaReal($valor)
    {
        return number_format($valor, 2, ',', '.');
    }

    public static function realParaDolar($valor)
    {
        return str_replace(",", ".",str_replace(".", "",$valor));
    }

}