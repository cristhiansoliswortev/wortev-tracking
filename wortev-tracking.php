<?php
/**
* Plugin Name: Wortev Tracking
* Plugin URI: https://www.wortev.com/
* Description: Crear tracking de landing pages
* Version: 1.0
* Authors: Cristhian Solis
* Author URI: http://wortev.com/
**/

function iniciar_session() {
    if ( ! session_id() ) {
        session_start();
    }
}
// iniciar session ahora.
add_action( 'init', 'iniciar_session' );

function guardar_sesion() {
    $respuesta=array(); 
    if (isset($_SESSION['archivo'])) { 
        $archivo=$_SESSION['archivo']; 
        $respuesta_archivo=file_get_contents(ABSPATH."wp-content/plugins/wortev-tracking/sesiones/".$archivo); 
        $respuesta=json_decode($respuesta_archivo, true);
        $respuesta['fecha_hora']['modificado']=date("Y-m-d H:i:s");
        
    } else {  
        $id=date("Y-m-d_H_i_s"); 
        $archivo=$_SERVER['REMOTE_ADDR']."_".$id.".json";  
        $respuesta['fecha_hora']['creado']=date("Y-m-d H:i:s");    
        $_SESSION['archivo']=$archivo;
    } 
 
    $archivo_json=ABSPATH."wp-content/plugins/wortev-tracking/sesiones/".$archivo; 
    $respuesta[]['sesion']=$_SESSION;
    $respuesta[]['cookie']=$_COOKIE;
    $respuesta[]['request']=$_REQUEST;
    
    // print_r($respuesta);
    $respuesta=json_encode($respuesta);
 
    $fp=fopen($archivo_json, "w");
    fwrite($fp, $respuesta);
    fclose($fp); 
    
}

// add_action("guardar_sesion", "guardar_sesion", 10);

add_action( 'init', 'guardar_sesion' ); 
 
add_action('admin_menu', 'agregar_sesiones_page');
function agregar_sesiones_page() {
    add_menu_page("Sesiones", "Sesiones", "manage_options", __FILE__, "ver_sesiones", "", 70);
    add_action('admin_init', 'registrar_mis_settings_trck');
}

function registrar_mis_settings_trck() {
    register_setting('mis_settings_trck', 'new_option_name');
    register_setting('mis_settings_trck', 'some_option_name');
    register_setting('mis_settings_trck', 'option_etc');
}
function mis_settings_trck() {

}

function ver_sesiones() {
    require "leer_pagina.php";
}