<?php

error_reporting(E_ALL);
 
/* Habilita a exibição de erros */
ini_set("display_errors", 1);

function autoload($classe)
{
    if (file_exists('classes/dao/' . $classe . '.php')) {
        include_once 'classes/dao/' . $classe . '.php';
        return;
    } else if (file_exists('classes/model/' . $classe . '.php')) {
        include_once 'classes/model/' . $classe . '.php';
        return;
    } else if (file_exists('classes/controller/' . $classe . '.php')) {
        include_once 'classes/controller/' . $classe . '.php';
        return;
    } else if (file_exists('classes/util/' . $classe . '.php')) {
        include_once 'classes/util/' . $classe . '.php';
        return;
    } else if (file_exists('classes/view/' . $classe . '.php')) {
        include_once 'classes/view/' . $classe . '.php';
        return;
    }else if (file_exists ( 'classes/custom/controller/' . $classe . '.php' )){
        include_once 'classes/custom/controller/' . $classe . '.php';
        return;
    }
    else if (file_exists ( 'classes/custom/view/' . $classe . '.php' )){
        include_once 'classes/custom/view/' . $classe . '.php';
        return;
    }else if(file_exists ( 'classes/custom/dao/' . $classe . '.php' )){
        include_once 'classes/custom/dao/' . $classe . '.php';
        return;
    }
    
    $prefix = 'PainelPDTI';
    $base_dir = 'classes/';
    $len = strlen($prefix);
    if (strncmp($prefix, $classe, $len) !== 0) {
        return;
    }
    $relative_class = substr($classe, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
    
}
spl_autoload_register('autoload');