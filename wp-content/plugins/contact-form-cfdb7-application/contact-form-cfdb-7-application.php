<?php
/*
Plugin name: Contact Form CFDB7-application
Description: Плагин для сохранения заявок в БД через форму подачи заявок. За основу взят плагин "Contact Form CFDB7"
Author: Evgenia Kugaevskaya

*/

function cfdb7_create_table(){

    global $wpdb;
    $cfdb       = apply_filters( 'cfdb7_database', $wpdb );
    $table_name = $cfdb->prefix.'db7_forms';

    if( $cfdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

        $charset_collate = $cfdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            form_id bigint(20) NOT NULL AUTO_INCREMENT,
            form_post_id bigint(20) NOT NULL,
            form_value longtext NOT NULL,
            form_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (form_id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    $upload_dir    = wp_upload_dir();
    $cfdb7_dirname = $upload_dir['basedir'].'/cfdb7_uploads';
    if ( ! file_exists( $cfdb7_dirname ) ) {
        wp_mkdir_p( $cfdb7_dirname );
    }
    add_option( 'cfdb7_view_install_date', date('Y-m-d G:i:s'), '', 'yes');

}

function cfdb7_on_activate( $network_wide ){

    global $wpdb;
    if ( is_multisite() && $network_wide ) {
        // Get all blogs in the network and activate plugin on each one
        $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
        foreach ( $blog_ids as $blog_id ) {
            switch_to_blog( $blog_id );
            cfdb7_create_table();
            restore_current_blog();
        }
    } else {
        cfdb7_create_table();
    }

    // Add custom capability
    $role = get_role( 'administrator' );
    $role->add_cap( 'cfdb7_access' );
}

register_activation_hook( __FILE__, 'cfdb7_on_activate' );


function cfdb7_on_deactivate() {

    // Remove custom capability from all roles
    global $wp_roles;

    foreach( array_keys( $wp_roles->roles ) as $role ) {
        $wp_roles->remove_cap( $role, 'cfdb7_access' );
    }
}

register_deactivation_hook( __FILE__, 'cfdb7_on_deactivate' );


function cfdb7_before_send_mail( $form_tag ) {

    global $wpdb;
    $cfdb          = apply_filters( 'cfdb7_database', $wpdb );
    $table_name    = $cfdb->prefix.'db7_forms';
    $table_name_app = $cfdb->prefix.'db7_forms_app';
    $upload_dir    = wp_upload_dir();
    $cfdb7_dirname = $upload_dir['basedir'].'/cfdb7_uploads';
    $cfdb7_urlname = $upload_dir['baseurl'].'/cfdb7_uploads';
    $time_now      = time();

    $form = WPCF7_Submission::get_instance();

    if ( $form ) {

        $black_list   = array('_wpcf7', '_wpcf7_version', '_wpcf7_locale', '_wpcf7_unit_tag',
        '_wpcf7_is_ajax_call','cfdb7_name', '_wpcf7_container_post','_wpcf7cf_hidden_group_fields',
        '_wpcf7cf_hidden_groups', '_wpcf7cf_visible_groups', '_wpcf7cf_options');

        $data           = $form->get_posted_data();
        $files          = $form->uploaded_files();
        $uploaded_files = array();
        
        $i = 0;
        foreach ($files as $file_key => $file) {            
            array_push($uploaded_files, $file_key);
            $info = new SplFileInfo(basename($file));
            $ex = $info->getExtension();
            copy($file, $cfdb7_dirname.'/'.$time_now.'-'.$i.'.'.$ex); 
            $i++;
        }

        $form_data = array();
        $arrayCheck = array();
        $arrayPoint = array();
        $arrayCheckVal = array();
        $arrayPointVal = array();
        $arrayPointKey = array();
        $arrayPointVal = array();

        $form_data['cfdb7_status'] = 'unread';
        foreach ($data as $key => $d) {
            if ( !in_array($key, $black_list ) && !in_array($key, $uploaded_files ) ) {
                $tmpD = $d;

                if ( ! is_array($d) ){

                    $bl   = array('\"',"\'",'/','\\');
                    $wl   = array('&quot;','&#039;','&#047;', '&#092;');

                    $tmpD = str_replace($bl, $wl, $tmpD );
                }

                $form_data[$key] = $tmpD;
            }
            
            if ($form_tag->id() ==  /*3593*/3656) : 
                $regCheck = "/cf7-check-title-[0-9]+/";
                $match = array();
                if (preg_match($regCheck, $key, $match)) :
                    $l = 0-strlen($key)+16;
                    $n = substr($key, $l);
                    array_push($arrayCheck, array('key' => $d, 'val' => 'cf7-check-'.$n));
                endif;

                $regPoint = "/cf7-point-title-[0-9]+/";
                $match = array();
                if (preg_match($regPoint, $key, $match)) :
                    $l = 0-strlen($key)+16;
                    $n = substr($key, $l);
                    array_push($arrayPoint, array('key' => $d, 'val' => 'cf7-point-'.$n));
                endif;
            endif;
                

            if ( in_array($key, $uploaded_files ) ) {
                if ($form_tag->id() ==  3241) :
                    $info = new SplFileInfo($d);
                    $ex = $info->getExtension();
                    if (in_array($key, array('cf7-text-poem', 'cf7-text-image-article', 'cf7-file', 'cf7-video-file', 'cf7-doc'))) :
                        $upload_dir = wp_upload_dir();
                        $file1 = $cfdb7_urlname.'/'.$time_now.'-0.'.$ex; 
                    endif;
                    if (in_array($key, array('cf7-single-poem', 'cf7-text-article'))) :
                        $file2 = $cfdb7_urlname.'/'.$time_now.'-1.'.$ex; 
                    endif;
                    if (in_array($key, array('cf7-image-article'))) :
                        $file3 = $cfdb7_urlname.'/'.$time_now.'-2.'.$ex; 
                    endif;
                endif;
                $form_data[$key.'cfdb7_file'] = $time_now.'-'.$d;
            }
        }

        /* cfdb7 before save data. */
        $form_data = apply_filters('cfdb7_before_save_data', $form_data);

        do_action( 'cfdb7_before_save_data', $form_data );

        $form_post_id = $form_tag->id();
        $form_value   = serialize( $form_data );
        $form_date    = current_time('Y-m-d H:i:s');

        $cfdb->insert( $table_name, array(
            'form_post_id' => $form_post_id,
            'form_value'   => $form_value,
            'form_date'    => $form_date
        ) );

        if ($form_tag->id() ==  3241) :
            $app_post = array(
                'post_title' => $form_data['your-subject'],
                'post_status' => 'publish',
                'post_type' => 'application',
                'post_author' => $form_data['user_id']
            );
            $post_id = wp_insert_post( $app_post );
            $id_concurs = $wpdb->get_results("select distinct(post_id) post_id from wp_postmeta where meta_value like '" . $form_data['cf7-concurs']  . "' and meta_key like 'concurs_title'");
            update_post_meta( $post_id, 'app_id_app', $post_id );
            update_post_meta( $post_id, 'app_concurs', $form_data['cf7-concurs'] );
            update_post_meta( $post_id, 'app_id_concurs', $id_concurs{0}->post_id );
            update_post_meta( $post_id, 'app_title', $form_data['your-subject'] );
            update_post_meta( $post_id, 'app_nomination', $form_data['cf7-nomination'] );
            update_post_meta( $post_id, 'app_theme', $form_data['cf7-theme'] );
            update_post_meta( $post_id, 'app_free_theme', $form_data['cf7-free-theme'] );
            update_post_meta( $post_id, 'app_second_name_party', $form_data['your-name'] );
            update_post_meta( $post_id, 'app_name_party', $form_data['cf7-name-party'] );
            update_post_meta( $post_id, 'app_otch_party', $form_data['cf7-otchestvo-party'] );

            $birthday = new DateTime(strval($form_data['cf7-birthday']));
            $now = new DateTime();        
            $age = $now->format('Y') - $birthday->format('Y');
            if ($birthday->format('md') > $now->format('md')) : $age--; endif;
            update_post_meta( $post_id, 'app_birthday', $birthday->format('d.m.Y') );
            update_post_meta( $post_id, 'app_age', $age );

            update_post_meta( $post_id, 'app_tel_party', $form_data['cf7-tel-party'] );
            update_post_meta( $post_id, 'app_email', $form_data['your-email'] );

            update_post_meta( $post_id, 'app_link_social', $form_data['cf7-link-social'] );
            update_post_meta( $post_id, 'app_activity_place', $form_data['cf7-activity-place'] );
            update_post_meta( $post_id, 'app_class', $form_data['cf7-class'] );
            update_post_meta( $post_id, 'app_edu', $form_data['cf7-edu'] );
            update_post_meta( $post_id, 'app_hobby', $form_data['cf7-hobby'] );

            update_post_meta( $post_id, 'app_region', $form_data['cf7-region'] );
            update_post_meta( $post_id, 'app_city', $form_data['cf7-city'] );
            update_post_meta( $post_id, 'app_np', $form_data['cf7-np'] );

            update_post_meta( $post_id, 'app_second_name_pr', $form_data['cf7-second-name-pr'] );
            update_post_meta( $post_id, 'app_name_pr', $form_data['cf7-name-pr'] );
            update_post_meta( $post_id, 'app_otchestvo_pr', $form_data['cf7-otchestvo-pr'] );
            update_post_meta( $post_id, 'app_tel_pr', $form_data['cf7-tel-pr'] );
            update_post_meta( $post_id, 'app_email_pr', $form_data['cf7-e-mail-pr'] );

            update_post_meta( $post_id, 'app_second_name_dir', $form_data['cf7-second-name-dir'] );
            update_post_meta( $post_id, 'app_name_dir', $form_data['cf7-name-dir'] );
            update_post_meta( $post_id, 'app_otchestvo_dir', $form_data['cf7-otchestvo-dir'] );

            $activity_place_dir = trim($form_data['cf7-activity-place-dir']);
            $post_dir = trim($form_data['cf7-post-dir']);

            if (!empty($activity_place_dir) && !empty($post_dir)) :
                $app_post_dir = $activity_place_dir . ', ' . $post_dir;
            elseif (!empty($activity_place_dir)  && empty($post_dir)) :
                $app_post_dir = trim($activity_place_dir);
            elseif (empty($activity_place_dir)  && !empty($post_dir)) :
                $app_post_dir = trim($post_dir);
            else: $app_post_dir = '';
            endif;

            update_post_meta( $post_id, 'app_post_dir', $app_post_dir );
            update_post_meta( $post_id, 'app_tel_dir', $form_data['cf7-tel-dir'] );
            update_post_meta( $post_id, 'app_email_dir', $form_data['cf7-e-mail-dir'] );

            update_post_meta( $post_id, 'app_reglam_personal_data', $form_data['cf7-reglam-personal-data'] );
            update_post_meta( $post_id, 'app_copyright', $form_data['cf7-copyright'] );

            update_post_meta( $post_id, 'app_file1', $file1 );
            update_post_meta( $post_id, 'app_file2', $file2 );
            update_post_meta( $post_id, 'app_file3', $file3 );

            update_post_meta( $post_id, 'app_status', 'Отправлена' );

            wp_set_object_terms( $post_id, $form_data['cf7-concurs'], 'tax_concurs' );
            wp_set_object_terms( $post_id, strval($age), 'tax_age' );
            wp_set_object_terms( $post_id, $form_data['cf7-nomination'], 'tax_nomination' );
        endif;
        
        if ($form_tag->id() ==  /*3593*/3656) :
            $str = '';
            $check = 0;
            $point = 0;            
            for ($i=0; $i < count($arrayCheck); $i++) :
                $s = ($form_data[$arrayCheck[$i]['val']] == 1) ? 'Да' : 'Нет';
                $str .= '<tr><td>' . $arrayCheck[$i]['key'] . '</td><td>' . $s . '</td></tr>';
                $check += $form_data[$arrayCheck[$i]['val']];
            endfor;
            if ($check == count($arrayCheck)) :
                for ($i=0; $i < count($arrayPoint); $i++) :
                    $str .= '<tr><td>' . $arrayPoint[$i]['key'] . '</td><td>' . $form_data[$arrayPoint[$i]['val']] . '</td></tr>';
                    $point += $form_data[$arrayPoint[$i]['val']];
                endfor;
            else :
                $point = NULL;
            endif;
            
            $str = '<table>' . $str . '</table>';
            
            
            $point_avg = (count($arrayPoint) > 0) ? $point/count($arrayPoint) : 0;
            $point_avg = ($point != NULL) ? round($point_avg,2) : NULL;


            $status = 'Отправлена';
            $status = ($check < count($arrayCheck)) ? 'Отклонена' : 'Допущена';
            $status = ($point != NULL) ? 'Оценена' : $status;

            $post_id = $form_data['app_id'];
            update_post_meta( $post_id, 'app_old_rating', $str );
            update_post_meta( $post_id, 'app_point_avg', $point_avg );
            update_post_meta( $post_id, 'app_status', $status );          
            update_post_meta( $post_id, 'app_comment', $form_data['cf7-comment'] );          
        endif;

        /* cfdb7 after save data */
        $insert_id = $cfdb->insert_id;
        do_action( 'cfdb7_after_save_data', $insert_id );
    }

}

add_action( 'wpcf7_before_send_mail', 'cfdb7_before_send_mail' );


add_action( 'init', 'cfdb7_init');

/**
 * CFDB7 cfdb7_init and cfdb7_admin_init
 * Admin setting
 */
function cfdb7_init(){

    do_action( 'cfdb7_init' );

    if( is_admin() ){

        require_once 'inc/admin-mainpage.php';
        require_once 'inc/admin-subpage.php';
        require_once 'inc/admin-form-details.php';
        require_once 'inc/export-csv.php';

        do_action( 'cfdb7_admin_init' );

        $csv = new Expoert_CSV();
        if( isset($_REQUEST['csv']) && ( $_REQUEST['csv'] == true ) && isset( $_REQUEST['nonce'] ) ) {

            $nonce  = filter_input( INPUT_GET, 'nonce', FILTER_SANITIZE_STRING );

            if ( ! wp_verify_nonce( $nonce, 'dnonce' ) ) wp_die('Invalid nonce..!!');

            $csv->download_csv_file();
        }
        new Cfdb7_Wp_Main_Page();
    }
}


add_action( 'admin_notices', 'cfdb7_admin_notice' );
add_action('admin_init', 'cfdb7_view_ignore_notice' );

function cfdb7_admin_notice() {

    $install_date = get_option( 'cfdb7_view_install_date', '');
    $install_date = date_create( $install_date );
    $date_now     = date_create( date('Y-m-d G:i:s') );
    $date_diff    = date_diff( $install_date, $date_now );

    if ( $date_diff->format("%d") < 7 ) {

        return false;
    }

    global $current_user ;
    $user_id = $current_user->ID;

    if ( ! get_user_meta($user_id, 'cfdb7_view_ignore_notice' ) ) {

        echo '<div class="updated"><p>';

        printf(__( 'Awesome, you\'ve been using <a href="admin.php?page=cfdb7-list.php">Contact Form CFDB7</a> for more than 1 week. May we ask you to give it a 5-star rating on WordPress? | <a href="%2$s" target="_blank">Ok, you deserved it</a> | <a href="%1$s">I already did</a> | <a href="%1$s">No, not good enough</a>', 'contact-form-cfdb7' ), '?cfdb7-ignore-notice=0',
        'https://wordpress.org/plugins/contact-form-cfdb7/');
        echo "</p></div>";
    }
}

function cfdb7_view_ignore_notice() {
    global $current_user;
    $user_id = $current_user->ID;

    if ( isset($_GET['cfdb7-ignore-notice']) && '0' == $_GET['cfdb7-ignore-notice'] ) {

        add_user_meta($user_id, 'cfdb7_view_ignore_notice', 'true', true);
    }
}

/**
 * Plugin settings link
 * @param  array $links list of links
 * @return array of links
 */
function cfdb7_settings_link( $links ) {
  $forms_link = '<a href="admin.php?page=cfdb7-list.php">Contact Forms</a>';
  array_unshift($links, $forms_link);
  return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'cfdb7_settings_link' );
