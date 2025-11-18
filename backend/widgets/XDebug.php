<?php
namespace app\widgets;

use Yii;
/**
 * Função que executa debug
 * pode ser passado vários argumentos para o debug
 * @param $vars
 * @return void
 */
class XDebug
{
    public static function x($vars){

        // Mostra onde o x foi chamado
        $arLocal = @debug_backtrace();
        $arLocal = array_shift($arLocal);
        $stLocal = 'Arquivo :'.$arLocal['file'] .' ---> Linha '.$arLocal['line']."<br><p>";

        echo "<div style='border: 1px solid black; padding: 10px; background-color: #ffff9f'>";
        echo $stLocal;

        foreach (func_get_args() as $idx=>$arg)
        {
            echo "<b><u>ARG[$idx]</u></b><br><pre>";
            print_r($arg);
            echo "</pre>";
        }
        echo "</div><br><br>";
        flush();
    }

    /**
     * Função que executa debug die() + x()
     * pode ser passado vários argumentos para o debug
     * @param $vars
     * @return void
     */
    public static function xd($vars) {
        // Mostra onde o x foi chamado
        $arLocal = @debug_backtrace();
        $arLocal = array_shift($arLocal);
        $stLocal = 'Arquivo :'.$arLocal['file'] .' ---> Linha '.$arLocal['line']."<br><p>";

        echo "<div style='border: 1px solid black; padding: 10px; background-color: #BBCCDD'>";
        echo $stLocal;

        foreach (func_get_args() as $idx=>$arg)
        {
            echo "<b><u>ARG[$idx]</u></b><br><pre>";
            print_r($arg);
            echo "</pre>";
        }
        echo "</div><br><br>";
        flush();
        die;
    }

    public static function varDump($vars){

        // Mostra onde o x foi chamado
        $arLocal = @debug_backtrace();
        $arLocal = array_shift($arLocal);
        $stLocal = 'Arquivo :'.$arLocal['file'] .' ---> Linha '.$arLocal['line']."<br><p>";

        echo "<div style='border: 1px solid black; padding: 10px; background-color: #ffff9f'>";
        echo $stLocal;

        foreach (func_get_args() as $idx=>$arg)
        {
            echo "<b><u>ARG[$idx]</u></b><br><pre>";
            var_dump($arg);
            echo "</pre>";
        }
        echo "</div><br><br>";
        flush();
    }

    /**
     * Função que executa debug die() + x()
     * pode ser passado vários argumentos para o debug
     * @param $vars
     * @return void
     */
    public static function varDumpDie($vars) {
        // Mostra onde o x foi chamado
        $arLocal = @debug_backtrace();
        $arLocal = array_shift($arLocal);
        $stLocal = 'Arquivo :'.$arLocal['file'] .' ---> Linha '.$arLocal['line']."<br><p>";

        echo "<div style='border: 1px solid black; padding: 10px; background-color: #BBCCDD'>";
        echo $stLocal;

        foreach (func_get_args() as $idx=>$arg)
        {
            echo "<b><u>ARG[$idx]</u></b><br><pre>";
            var_dump($arg);
            echo "</pre>";
        }
        echo "</div><br><br>";
        flush();
        die;
    }
}