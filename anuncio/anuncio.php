<?php
/*
Plugin Name: Anuncio
*/

require_once plugin_dir_path(__FILE__) . 'includes/anuncio_functions.php';
//require_once plugin_dir_path(__FILE__) . 'includes/send_data.php';


function create_anuncio_table()
{
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $prefix = $wpdb->prefix;
    $table_name = $prefix . 'custom_anuncio';

    if (count($wpdb->get_var('SHOW TABLES LIKE "' . $table_name . '"')) == 0) {
        $sl_query = "CREATE TABLE " . $table_name . "(
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            ds_nome VARCHAR(50) NOT NULL,
            ds_descricao VARCHAR(100) NOT NULL,
            ds_tags VARCHAR(50),
            ds_link_imagem VARCHAR(100),
            dt_registro DATETIME,
            dt_alteracao DATETIME
            )";
        dbDelta($sl_query);
    }
}
register_activation_hook(__FILE__, 'create_anuncio_table');

function create_folder_images() {
 
    $upload = wp_upload_dir();
    $upload_dir = $upload['basedir'];
    $upload_dir = $upload_dir . '/images';
    if (! is_dir($upload_dir)) {
       mkdir( $upload_dir, 0700 );
    }
}
 
register_activation_hook( __FILE__, 'create_folder_images' );
