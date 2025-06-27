<?php

//-----------------------------------------------------
//DEBUG
//-----------------------------------------------------
/**
 * Debugger para imprimir  $data en la consola js, en el plugin de profesores y proyectos
 * @param type $data
 */
class DiscProfProyUtilidades {

    private static $debug_active = false;

    public static function debug_to_console($data) {

        if (self::$debug_active) {
            if (is_array($data)) {
                $output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
            } else {
                $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
            }
            echo $output;
        }
    }

    public static function debug_to_echo($data) {

        if (self::$debug_active) {
            if (is_array($data)) {

                echo "<pre> ";
                echo print_r($data);
                //echo var_dump($data);
                echo "</pre>";
            } else {
                echo $data . "<br>";
            }
        }
    }

    public static function debug_to_echo_with_code_box($data) {

        if (self::$debug_active) {
            if (is_array($data)) {

                echo "<pre> ";
                echo print_r($data);
                //echo var_dump($data);
                echo "</pre>";
            } else {
                echo "<pre> ";
                echo $data . "<br>";
                echo "</pre>";
            }
        }
    }

     public static function debug_to_echo_var_dump($data) {

        if (self::$debug_active) {
            if (is_array($data)) {

                echo "<pre> ";
                echo var_dump($data);
                echo "</pre>";
            } else {
                echo var_dump($data) . "<br>";
            }
        }
    }

    //-----------------------------------------------------------------------
    // NOTICE FUNCTIONS ( Mensajes para mostrar en la zona de administración)
    //-----------------------------------------------------------------------

    public static function show_success_notice($titulo, $mensaje) {
        echo("<div class='notice notice-success is-dismissible' style='padding: 10px'>"
        . "<strong>" . $titulo . ": " . "</strong> "
        . "<br>" . "$mensaje</div>");
    }

    public static function show_update_notice($titulo, $mensaje) {
        echo("<div class='updated notice is-dismissible' style='padding: 10px'>"
        . "<strong>" . $titulo . ": " . "</strong> "
        . "<br>" . "$mensaje</div>");
    }

    public static function show_info_notice($titulo, $mensaje) {
        echo("<div class='notice notice-info is-dismissible' style='padding: 10px'>"
        . "Info: <strong>" . $titulo . ": " . "</strong> "
        . "<br>" . "$mensaje</div>");
    }

    public static function show_warning_notice($titulo, $mensaje) {
        echo("<div class='notice notice-warning is-dismissible' style='padding: 10px'>"
        . "Warning !! <strong>" . $titulo . ": " . "</strong> "
        . "<br>" . "$mensaje</div>");
    }

    public static function show_error_notice($titulo, $mensaje) {
        echo("<div class='error notice is-dismissible' style='padding: 10px'>"
        . "Error !! <strong>" . $titulo . "</strong>"
        . "<br>" . $mensaje
        . "</div>");
    }

    public static function show_error_notice_not_dismissible($titulo, $mensaje) {
        echo("<div class='notice notice-error' style='padding: 10px'>"
        . "Error !! <strong>" . $titulo . "</strong>"
        . "<br>" . $mensaje
        . "</div>");
    }

    /**
     * Metodo para prender y apagar datos de debug ( el debugger o if que hagan prints o echos )
     * @return boolean
     */
    public static function DiscProfProyUtilidades_debug_active() {
        return self::$debug_active;
    }

}
