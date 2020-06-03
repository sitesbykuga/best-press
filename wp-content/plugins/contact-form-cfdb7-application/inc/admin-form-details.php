<?php

if (!defined( 'ABSPATH')) exit;

/**
*
*/
class CFdb7_Form_Details
{
    private $form_id;
    private $form_post_id;


    public function __construct()
    {
       $this->form_post_id = esc_sql( $_GET['fid'] );
       $this->form_id = esc_sql( $_GET['ufid'] );

       $this->form_details_page();
    }

    public function form_details_page(){
        global $wpdb;
        $cfdb          = apply_filters( 'cfdb7_database', $wpdb );
        $table_name    = $cfdb->prefix.'db7_forms';
        $upload_dir    = wp_upload_dir();
        $cfdb7_dir_url = $upload_dir['baseurl'].'/cfdb7_uploads';
        $array_5515    = array("res-name" => "Имя"
                               , "res-second-name" => "Фамилия"
                               , "res-tel" => "Телефон"
                               , "res-tel-viber" => "Телефон для Вайбера"
                               , "res-email" => "E-mail"
                               , "res-soc" => "Социальные сети"
                               , "res-studio" => "Кружок/студия"
                               , "res-child-yn" => "Ребенок"
                               , "res-child-gender" => "Пол ребенка"
                               , "res-child-age" => "Возраст ребенка"
                               , "res-child-privilege-yn" => "Льготная категория"
                               , "res-reglam-personal-data" => "Согласие на обработку персональных данных"
                        );

        $array_5544    = array("event-title" => "Мероприятие"
                                , "event-name" => "ФИО"
                                , "event-org" => "Организация"
                                , "event-class" => "Класс/курс/должность"
                                , "event-tel" => "Телефон"
                                , "event-email" => "E-mail"
                                , "event-soc" => "Социальные сети"
                                , "event-reglam-personal-data" => "Согласие на обработку персональных данных"
                        );

        $array_5541    = array("question-name" => "ФИО"
                                , "question-tel" => "Телефон"
                                , "question-email" => "E-mail"
                                , "question-text" => "Социальные сети"
                                , "question-reglam-personal-data" => "Согласие на обработку персональных данных"
                        );

        if ( is_numeric($this->form_post_id) && is_numeric($this->form_id) ) {

           $results    = $cfdb->get_results( "SELECT * FROM $table_name WHERE form_post_id = $this->form_post_id AND form_id = $this->form_id LIMIT 1", OBJECT );
        }

        if ( empty($results) ) {
            wp_die( $message = 'Not valid contact form' );
        }
        ?>
        <div class="wrap">
            <div id="welcome-panel" class="welcome-panel">
                <div class="welcome-panel-content">
                    <div class="welcome-panel-column-container">
                        <?php do_action('cfdb7_before_formdetails_title',$this->form_post_id ); ?>
                        <h3><?php echo get_the_title( $this->form_post_id ); ?></h3>
                        <?php do_action('cfdb7_after_formdetails_title', $this->form_post_id ); ?>
                        <p></span><?php echo '<b>Дата и время</b>: '.$results[0]->form_date; ?></p>
                        <?php $form_data  = unserialize( $results[0]->form_value );

                        foreach ($form_data as $key => $data):

                            if ( $key == 'cfdb7_status' )  continue;
                            if ( $key == '_wpcf7cf_repeaters' ) continue;
                            if ( $key == '_wpcf7cf_steps' ) continue;

                            if ( strpos($key, 'cfdb7_file') !== false ){

                                if ( $this->form_post_id == 5515 )
                                    $key_val = 'Файл по льготникам';
                                else {
                                    $key_val = str_replace('cfdb7_file', '', $key);
                                    $key_val = str_replace('your-', '', $key_val);
                                    $key_val = ucfirst( $key_val );
                                }

                                $ex = substr( $data, strrpos( $data, '.' ) );
                                $filename = substr( $data, 0, stripos( $data, '-' ) )."-0".$ex;                                 

                                echo '<p><b>'.$key_val.'</b>: <a href="'.$cfdb7_dir_url.'/'.$filename.'" target="_blank">'
                                .$filename.'</a></p>';
                            }else{


                                if ( is_array($data) ) {

                                    $key_val = str_replace('your-', '', $key);
                                    $key_val = ucfirst( $key_val );
                                    $arr_str_data =  implode(', ',$data);
                                    echo '<p><b>'.$key_val.'</b>: '. nl2br($arr_str_data) .'</p>';

                                }else{
                                    if ( $this->form_post_id == 5515 )
                                        foreach ($array_5515 as $key_5515 => $v_5515) {
                                            if ($key == $key_5515) {
                                                $key_val = $v_5515;                                            
                                                break;
                                            }
                                        }
                                    elseif ( $this->form_post_id == 5544 )
                                        foreach ($array_5544 as $key_5544 => $v_5544) {
                                            if ($key == $key_5544) {
                                                $key_val = $v_5544;                                            
                                                break;
                                            }
                                        }  
                                    elseif ( $this->form_post_id == 5541 )
                                        foreach ($array_5541 as $key_5541 => $v_5541) {
                                            if ($key == $key_5541) {
                                                $key_val = $v_5541;                                            
                                                break;
                                            }
                                        }                                        
                                    else {
                                    $key_val = str_replace('your-', '', $key);
                                    $key_val = ucfirst( $key_val );
                                    }
                                    echo '<p><b>'.$key_val.'</b>: '.nl2br($data).'</p>';
                                }
                                
                            }

                        endforeach;

                        $form_data['cfdb7_status'] = 'read';
                        $form_data = serialize( $form_data );
                        $form_id = $results[0]->form_id;

                        $cfdb->query( "UPDATE $table_name SET form_value =
                            '$form_data' WHERE form_id = $form_id"
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        do_action('cfdb7_after_formdetails', $this->form_post_id );
    }

}
