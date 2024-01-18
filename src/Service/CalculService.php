<?php

namespace App\Service;

class CalculService
{

    public static function calculate($var1, $var2, $op)
    {
        $resultat = match ($op) {
            "plus" => ["op" => '+', "value" => $var1 + $var2],
            "moins" => ["op" => '-', "value" => $var1 - $var2],
            "div" => ["op" => '/', "value" => $var1 / $var2],
            "fois" => ["op" => '*', "value" => $var1 * $var2],
            default => ["value" => "Erreur : opérateur inconnu"]
        };
        return $resultat;
    }

}