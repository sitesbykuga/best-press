<?php 
/**
Plugin Name: Администрирование Конкурсов
Author: Кугаевская Евгения

Description: Плагин необходим для инициализации процессов подведения итогов конкурсов, формирования списка участников, формирования ссылки для скачивания/откртытия диплома/сертификата 
*/
require_once plugin_dir_path(__FILE__) . 'includes/a2c-function.php';

function a2c_plugin_scripts() {
	wp_enqueue_script( 'a2c_btn_sum',  plugins_url('app-admin-concurs/assets/js/a2c_btn_sum.js'), array('jquery'), '1.05' );
	wp_enqueue_script( 'a2c_btn_dip',  plugins_url('app-admin-concurs/assets/js/a2c_btn_dip.js'), array('jquery'), '3.02' );
	


	wp_enqueue_script( 'a2c_btn_list_party',  plugins_url('app-admin-concurs/assets/js/a2c_btn_list_party.js'), array('jquery'), '7' );
	wp_enqueue_script( 'pdfmake',  plugins_url('app-admin-concurs/assets/js/pdfmake.min.js') );
	wp_enqueue_script( 'vfs_fonts',  plugins_url('app-admin-concurs/assets/js/vfs_fonts.js') );
	wp_enqueue_script( 'a2c_pdfmake',  plugins_url('app-admin-concurs/assets/js/a2c_pdfmake.js'), array('pdfmake','vfs_fonts'), '11' );
} 
add_action( 'wp_footer', 'a2c_plugin_scripts' );

/*Подведение итогов*/
add_action('wp_ajax_a2c_summarizing', 'a2c_summarizing');
add_action('wp_ajax_nopriv_a2c_summarizing', 'a2c_summarizing');

function a2c_summarizing(){
	$id_concurs = $_POST['id_concurs'];
	echo a2c_find_winner($id_concurs);
	wp_die();	
}

/*Список участников*/
add_action('wp_ajax_a2c_listparty', 'a2c_listparty');
add_action('wp_ajax_nopriv_a2c_listparty', 'a2c_listparty');

function a2c_listparty(){
	$a2c_attr = $_POST['attr'];
	$a2c_id_concurs = $_POST['id_concurs'];
	echo a2c_create_list($a2c_id_concurs, $a2c_attr);
	wp_die();
}

/*Ссылка на дипломт*/
add_action('wp_ajax_a2c_dip', 'a2c_dip');
add_action('wp_ajax_nopriv_a2c_dip', 'a2c_dip');

function a2c_dip(){
	$a2c_app_id = $_POST['app_id'];
	$a2c_app_status = $_POST['app_status'];
	echo a2c_link_dip($a2c_app_id, $a2c_app_status);
	wp_die();
}
