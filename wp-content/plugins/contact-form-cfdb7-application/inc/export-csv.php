<?php
/**
 * CFDB7 csv
 */

if (!defined( 'ABSPATH')) exit;

class Expoert_CSV{

    /**
     * Download csv file
     * @param  String $filename
     * @return file
     */
    public function download_send_headers( $filename ) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");

    }
    /**
     * Convert array to csv format
     * @param  array  &$array
     * @return file csv format
     */
    public function array2csv(array &$array){

        if (count($array) == 0) {
            return null;
        }
        ob_start();

        $df         = fopen("php://output", 'w');
        $array_keys = array_keys($array);
        $heading    = array();
        $unwanted   = array('cfdb7_', 'your-');

        foreach ( $array_keys as $aKeys ) {
            $tmp       = str_replace( $unwanted, '', $aKeys );
            $heading[] = ucfirst( $tmp );
        }
        fputcsv( $df, $heading );

        foreach ( $array['№ записи'] as $line => $form_id ) {
            $line_values = array();
            foreach($array_keys as $array_key ) {
                $line_values[ $array_key ] = $array[ $array_key ][ $line ];
            }
            fputcsv($df, $line_values);
        }
        fclose( $df );
        return ob_get_clean();
    }
    /**
     * Download file
     * @return csv file
     */
    public function download_csv_file(){

        global $wpdb;
        $cfdb        = apply_filters( 'cfdb7_database', $wpdb );
        $table_name  = $cfdb->prefix.'db7_forms';

        if( isset($_REQUEST['csv']) && isset( $_REQUEST['nonce'] ) ){

            $nonce =  $_REQUEST['nonce'];
            if ( ! wp_verify_nonce( $nonce, 'dnonce')) {

                wp_die( 'Not Valid.. Download nonce..!! ' );
            }
            $fid     = (int)$_REQUEST['fid'];
            $results = $cfdb->get_results("SELECT form_id, form_value, form_date FROM $table_name
                WHERE form_post_id = '$fid' ",OBJECT);
           
            $data  = array();
            $i     = 0;
            foreach ($results as $result) :
                
                $i++;
                $data['№ записи'][$i]    = $result->form_id;
                $data['Дата'][$i]  = $result->form_date;
                $resultTmp              = unserialize( $result->form_value );
                $upload_dir             = wp_upload_dir();
                $cfdb7_dir_url          = $upload_dir['baseurl'].'/cfdb7_uploads';

                unset($resultTmp["_wpcf7cf_steps"]);
                unset($resultTmp["_wpcf7cf_repeaters"]);
                unset($resultTmp["cfdb7_status"]);
                unset($resultTmp["res-child-privilege-file"]);

                $this->change_key_in_arr("res-name", "Имя", $resultTmp );
                $this->change_key_in_arr("res-second-name", "Фамилия", $resultTmp );
                $this->change_key_in_arr("res-tel", "Телефон", $resultTmp );
                $this->change_key_in_arr("res-tel-viber", "Телефон для Вайбера", $resultTmp );
                $this->change_key_in_arr("res-email", "E-mail", $resultTmp );
                $this->change_key_in_arr("res-soc", "Социальные сети", $resultTmp );
                $this->change_key_in_arr("res-studio", "Кружок", $resultTmp );
                $this->change_key_in_arr("res-child-yn", "Ребенок", $resultTmp );
                $this->change_key_in_arr("res-child-gender", "Пол ребенка", $resultTmp );
                $this->change_key_in_arr("res-child-age", "Возраст ребенка", $resultTmp );
                $this->change_key_in_arr("res-child-privilege-yn", "Льготная категория", $resultTmp );
                $this->change_key_in_arr("res-reglam-personal-data", "Согласие на обработку персональных данных", $resultTmp );
                $this->change_key_in_arr("res-child-privilege-file", "Ссылка на файл", $resultTmp );

                $this->change_key_in_arr("event-title", "Мероприятие", $resultTmp );
                $this->change_key_in_arr("event-name", "ФИО", $resultTmp );
                $this->change_key_in_arr("event-tel", "Телефон", $resultTmp );
                $this->change_key_in_arr("event-org", "Организация", $resultTmp );
                $this->change_key_in_arr("event-email", "E-mail", $resultTmp );
                $this->change_key_in_arr("event-soc", "Социальные сети", $resultTmp );
                $this->change_key_in_arr("event-class", "Класс/курс/должность", $resultTmp );
                $this->change_key_in_arr("event-reglam-personal-data", "Согласие на обработку персональных данных", $resultTmp );

                $this->change_key_in_arr("question-name", "ФИО", $resultTmp );
                $this->change_key_in_arr("question-tel", "Телефон", $resultTmp );
                $this->change_key_in_arr("question-email", "E-mail", $resultTmp );
                $this->change_key_in_arr("question-text", "Сообщение", $resultTmp );
                $this->change_key_in_arr("question-reglam-personal-data", "Согласие на обработку персональных данных", $resultTmp );
                foreach ($resultTmp as $key => $value):

                    if (strpos($key, 'cfdb7_file') !== false ){
                        if ($fid == 5515) {
                            $ex = substr( $value, strrpos( $value, '.' ) );
                            $filename = substr( $value, 0, stripos( $value, '-' ) )."-0".$ex;
                            $data["Ссылка на файл"][$i] = $cfdb7_dir_url.'/'.$filename;
                        }
                        else $data[$key][$i] = $cfdb7_dir_url.'/'.$value;
                        continue;
                    }
                    if ( is_array($value) ){

                        $data[$key][$i] = implode(', ', $value);
                        continue;
                    }

                   $data[$key][$i] = str_replace( array('&quot;','&#039;','&#047;','&#092;', "\r\n", "\r", "\n")
                    , array('"',"'",'/','\\',' ',' ',' '), $value );

                endforeach;

            endforeach;

            $this->download_send_headers( "cfdb7-" . date("Y-m-d") . ".csv" );
            echo $this->array2csv( $data );
            die();
        }
    }

    public function change_key_in_arr($old_key, $new_key, &$arr){
        if (array_key_exists($old_key, $arr) && !array_key_exists($new_key, $arr)) {
            $arr[$new_key]=$arr[$old_key];
            unset($arr[$old_key]);
        }

    }
}