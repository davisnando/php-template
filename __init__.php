<?php
if(strtolower(DEBUG) == "true"){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
require_once("settings/config.php");
require_once("settings/functions.php");
$var = $_GET['path'];
RunFunc("settings/urls.php", $var);

function RunFunc($urlfile,$path,$oldpath=null){
    require($urlfile);
    if($path != ""){
        if(substr($path, -1) == "/"){
            $path = str_replace("/","",$path);
        }
    }
    $path1 = explode('/',$path);
    if(array_key_exists($path,$url)){
        $func = $url[$path];
        if(preg_match('/urls.php/',$func)){
            if($oldpath == null){
                $path1 = explode('/',$path);
                if(count($path1) > 1){
                    $path = str_replace($path1[0]. '/',"",$path);
                }else{
                    $path = "";
                }
            }else{
                $path1 = explode('/',$oldpath);
                if(count($path1) > 1){
                    $path = str_replace($path1[0]. '/',"",$path);
                }else{
                    $path = "";
                }
            }
            RunFunc($func,$path);
            return;
        }
        $func();
    }else if(array_key_exists($path1[0],$url)){
        $func = $url[$path1[0]];
        if(preg_match('/urls.php/',$func)){
            if($oldpath == null){
                $path1 = explode('/',$path);
                if(count($path1) > 1){
                    $path = str_replace($path1[0]. '/',"",$path);
                }else{
                    $path = "";
                }
            }else{
                $path1 = explode('/',$oldpath);
                if(count($path1) > 1){
                    $path = str_replace($path1[0]. '/',"",$path);
                }else{
                    $path = "";
                }
            }
            RunFunc($func,$path);
            return;
        }
        $func();
        
    }else{
        $oldpath = $path;
        $path1 = explode('/',$path);
        $keyname = $path1[0].'$';
        if(array_key_exists($keyname,$url)){
            RunFunc($urlfile,$keyname,$oldpath);
            return;
        }else{
            $oldpath = $_GET['path'];
            if(file_exists($oldpath) && preg_match('/static/',$oldpath)){
                $type = getFileMimeType($oldpath);
                echo $type;
                header('Content-Type: '.$type);
                require($oldpath);
            }else{
                http_response_code(404);
            }
        }
    }
}

?>