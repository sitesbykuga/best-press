<?php

/*Формирование списка участников*/
function a2c_create_list($id_concurs, $attr) {
	global $wpdb;

	$arr_age = array();
	if( have_rows('order_age', $id_concurs) ):
		while ( have_rows('order_age', $id_concurs) ) : 
			the_row(); 
			$max_age = get_sub_field('order_max_age', $id_concurs);	
			$min_age = get_sub_field('order_min_age', $id_concurs);												
			if ( $min_age == 'до' ):
				$min_age = 0;
			elseif ( $min_age == 'старше' ) : 
				$min_age = $max_age;
				$max_age = 100;
			endif;

			if ( ctype_digit(get_sub_field('order_min_age')) ):
				$max_age_str = ' - ' . $max_age;
			endif;

			$field_age = get_sub_field_object('order_age_postfix');
			$value_age = $field_age['value'];
			$age_group = get_sub_field('order_min_age') . $max_age_str . ' ' . $field_age['choices'][ $value_age ];

			array_push($arr_age, array('min' => $min_age, 'max' => $max_age, 'title' => $age_group));
		endwhile;
	else :
		array_push($arr_age, array('min' => 0, 'max' => 100));
	endif; 

	$posts = $wpdb->get_results("select distinct post_id from wp_postmeta where meta_key like 'app_id_concurs' and meta_value = "  .  $id_concurs . " and post_id in (SELECT ID FROM wp_posts t where t.post_type LIKE 'application' and post_status like 'publish')");

	$arr_field = array();

	foreach ($posts as $post) :
		$arr_field_val = array();

		$app_fio_party = '';
		$app_fio_pred = '';
		$app_fio_dir = '';

     foreach ($attr as $field) :
      if ($field == 'app_age_group') :
       $age = $wpdb->get_results("select distinct meta_value from wp_postmeta where meta_key like 'app_age' and post_id = '" . $post->post_id . "'");
       foreach ($arr_age as $age_gr) :
        if (($age{0}->meta_value >= $age_gr['min']) && ($age{0}->meta_value <= $age_gr['max'])) :
         $arr_field_val['app_age_group'] = $age_gr['title'];
     break;
     else : $arr_field_val['app_age_group'] = 'Вне возрастной группы';
     endif;
 endforeach;	
elseif ($field == 'app_npp') :
   $arr_field_val['app_npp'] = '';
elseif ($field == 'app_date') :
   $date = $wpdb->get_results("SELECT DATE_FORMAT(post_date, '%d.%m.%Y') d FROM wp_posts where ID = " . $post->post_id . " and post_status like 'publish'");
   $arr_field_val['app_date'] = empty($date{0}->d) ? '' : $date{0}->d;    			
elseif ($field == 'app_fio_party') :
   $arr_field_val['app_fio_party'] = trim($app_fio_party);
elseif ($field == 'app_fio_pred') :
   $arr_field_val['app_fio_pred'] = trim($app_fio_pred);
elseif ($field == 'app_fio_dir') :
   $arr_field_val['app_fio_dir'] = trim($app_fio_dir);
else:
   $field_val = $wpdb->get_results("select distinct meta_value from wp_postmeta where meta_key like '" . $field . "' and post_id = '" . $post->post_id . "'");
   $decode = html_entity_decode($field_val{0}->meta_value);
   if ($field == 'app_point_avg') :
    $decode = str_replace(".", ",", $decode);
endif;
$decode = str_replace(array("\r\n", "\r", "\n"), " ", $decode);
$arr_field_val[$field] = empty($field_val{0}->meta_value) ? '' : $decode;

if ($field == 'app_second_name_party') :
    $app_fio_party .= $arr_field_val[$field] . ' ';
endif;
if ($field == 'app_name_party') :
    $app_fio_party .= $arr_field_val[$field] . ' ';
endif;
if ($field == 'app_otch_party') :
    $app_fio_party .= $arr_field_val[$field];
endif;

if ($field == 'app_second_name_pr') :
    $app_fio_pred .= $arr_field_val[$field] . ' ';
endif;
if ($field == 'app_name_pr') :
    $app_fio_pred .= $arr_field_val[$field] . ' ';
endif;
if ($field == 'app_otchestvo_pr') :
    $app_fio_pred .= $arr_field_val[$field];
endif;

if ($field == 'app_second_name_dir') :
    $app_fio_dir .= $arr_field_val[$field] . ' ';
endif;
if ($field == 'app_name_dir') :
    $app_fio_dir .= $arr_field_val[$field] . ' ';
endif;
if ($field == 'app_otchestvo_dir') :
    $app_fio_dir .= $arr_field_val[$field];
endif;
endif;    		 
endforeach;	

array_push($arr_field, $arr_field_val);    	
endforeach;



$field_list = array(
    'app_npp' => '№ п/п' 
    , 'app_second_name_party' => 'Фамилия участника'
    , 'app_name_party' => 'Имя участника'
    , 'app_otch_party' => 'Отчество участника'                
    , 'app_fio_party' => 'ФИО участника'
    , 'app_id_app' => '№ заявки'
    , 'app_date' => 'Дата подачи'
    , 'app_title' => 'Наименование работы'
    , 'app_concurs' => 'Конкурс'
    , 'app_nomination' => 'Номинация'
    , 'app_theme' => 'Тема'
    , 'app_free_theme' => 'Cвободная тема'
    , 'app_age_group' => 'Возрастная категория'
    , 'app_point_avg' => 'Средний балл'
    , 'app_status' => 'Статус заявки'
    , 'app_birthday' => 'Дата рождения'
    , 'app_age' => 'Возраст на момент подачи заявки'
    , 'app_tel_party' => 'Телефон участника'
    , 'app_email' => 'E-mail участника'
    , 'app_link_social' => 'Социальные сети'
    , 'app_activity_place' => 'Место учебы'
    , 'app_class' => 'Класс'
    , 'app_edu' => 'Образование'
    , 'app_hobby' => 'Хобби'
    , 'app_region' => 'Место проживания. Регион'
    , 'app_city' => 'Место проживания. Город/Район'
    , 'app_np' => 'Место проживания. Район города/Населенный пункт'
    , 'app_second_name_pr' => 'Фамилия представителя'
    , 'app_name_pr' => 'Имя представителя'
    , 'app_otchestvo_pr' => 'Отчество представителя'
    , 'app_fio_pred' => 'ФИО представителя'
    , 'app_tel_pr' => 'Телефон представителя'
    , 'app_email_pr' => 'E-mail представителя'
    , 'app_second_name_dir' => 'Фамилия руководителя'
    , 'app_name_dir' => 'Имя руководителя'
    , 'app_otchestvo_dir' => 'Отчество руководителя'
    , 'app_fio_dir' => 'ФИО руководителя'
    , 'app_post_dir' => 'Место работы и занимаемая должность'
    , 'app_tel_dir' => 'Телефон руководителя'
    , 'app_email_dir' => 'E-mail руководителя'
);

$str = '';
foreach ($attr as $key) :
 foreach ($field_list as $field => $value) :
  if ($field == $key) :
   $str .= $value . '**++**';
endif;
endforeach;
endforeach;
$str .= '*+*';



foreach ($arr_field as $app) :
 foreach ($app as $key => $value) :
  foreach ($attr as $field) :
   if ($field == $key) :
    $str .= $value . '**++**';
endif;
endforeach;
endforeach;    	
$str .= '*+*';
endforeach;

return($str); 
}

/*Сохранение списка участников*/
function a2c_save_list($id_concurs, $attr) {
	global $wpdb;

	$cfdb          = apply_filters( 'cfdb7_database', $wpdb );
    $table_name    = $cfdb->prefix.'a2c_list_party';

    $id = $wpdb->get_results("select distinct id from wp_a2c_list_party");
    if (!empty($id)) :
    	foreach ($id as $v) :
    		$wpdb->delete( $table_name, array('id' => $v->id) );
    	endforeach;
    endif;

    $attr_str = implode('*+*', $attr);

    $cfdb->insert( $table_name, array('id_concurs' => $id_concurs, 'attr' => $attr_str));	
}

/*Поиск победителя*/
function a2c_find_winner($id_concurs) {	
	$arr_age = array();
	if( have_rows('order_age', $id_concurs) ):
		while ( have_rows('order_age', $id_concurs) ) : 
			the_row(); 
			$max_age = get_sub_field('order_max_age', $id_concurs);	
			$min_age = get_sub_field('order_min_age', $id_concurs);												
			if ( $min_age == 'до' ):
				$min_age = 0;
			elseif ( $min_age == 'старше' ) : 
				$min_age = $max_age;
				$max_age = 100;
			endif;
			array_push($arr_age, array('min' => $min_age, 'max' => $max_age));
		endwhile;
	else :
		array_push($arr_age, array('min' => 0, 'max' => 100));
	endif; 

	$arr_nomination = array();
	if( have_rows('order_nomination', $id_concurs) ):
		while ( have_rows('order_nomination', $id_concurs) ) : 
			the_row(); 
			$nomination = get_sub_field('nomination_name', $id_concurs);
			array_push($arr_nomination, array($nomination));
		endwhile;
	endif; 

	$arr_nomination;

	$concurs = get_field('concurs_title', $id_concurs);

	global $wpdb;
	$arr_winner = array();

	foreach ($arr_age as $age) :
		foreach ($arr_nomination as $nom) :

			$min = $age['min'];
			$max = $age['max'];
			$nomination = $nom[0];

			$num_point = array();
			$winner = $wpdb->get_results("select distinct t.post_id, av.point from (SELECT post_id, meta_value concurs FROM wp_postmeta where meta_key like 'app_concurs' and meta_value like '" .  $concurs . "') t left join (select meta_value point, post_id from  wp_postmeta where meta_key like 'app_point_avg') av on t.post_id = av.post_id where t.post_id in (select  post_id from  wp_postmeta s	where meta_key like 'app_status' and (meta_value like 'Оценена' or meta_value like '1 место' or meta_value like '2 место' or meta_value like '3 место')) and t.post_id in (select post_id from  wp_postmeta ag	where meta_key like 'app_age' and meta_value between " . $min . " and " . $max . ") and t.post_id in (select post_id from  wp_postmeta n where meta_key like 'app_nomination' and meta_value like '" . $nomination . "') order by av.point desc","OBJECT");
			$point = $wpdb->get_results("select distinct av.point from (SELECT post_id, meta_value concurs FROM wp_postmeta where meta_key like 'app_concurs' and meta_value like '" .  $concurs . "') t left join (select meta_value point, post_id from  wp_postmeta where meta_key like 'app_point_avg') av on t.post_id = av.post_id where t.post_id in (select  post_id from  wp_postmeta s	where meta_key like 'app_status' and (meta_value like 'Оценена' or meta_value like '1 место' or meta_value like '2 место' or meta_value like '3 место')) and t.post_id in (select post_id from  wp_postmeta ag	where meta_key like 'app_age' and meta_value between " . $min . " and " . $max . ") and t.post_id in (select post_id from  wp_postmeta n where meta_key like 'app_nomination' and meta_value like '" . $nomination . "') order by av.point desc","OBJECT");
			
			$i = 1;
			foreach ($point as $key => $d) {
				array_push($num_point, array('num' => $i, 'point' => $d->point));
				$i++;
			}

			foreach ($winner as $win) :
				foreach ($num_point as $key) :
					if ($win->point == $key['point']) :
						array_push($arr_winner, array('post_id' => $win->post_id, 'num' => $key['num']));
					endif;
				endforeach;
			endforeach;
		endforeach;
	endforeach;

	foreach ($arr_winner as $win) :
		if ($win['num'] == 1) :
			update_post_meta( $win['post_id'], 'app_status', '1 место' );
		elseif ($win['num'] == 2) :
			update_post_meta( $win['post_id'] , 'app_status', '2 место' );
		elseif ($win['num'] == 3) :
			update_post_meta( $win['post_id'], 'app_status', '3 место' );
		endif;
	endforeach;

	update_post_meta( $id_concurs, 'summarizing', true );
	return count($winner) + count($point);
}

/*Ссылка на диплом*/

function a2c_link_dip($a2c_app_id, $a2c_app_status) {

    $white_base64 = 'data:image/jpg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wAARCAJbAwQDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9U6KKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD/9k=';
    
    $fio = get_field('app_name_party', $a2c_app_id) . ' ' . get_field('app_second_name_party', $a2c_app_id);
    $fio_dir2 = get_field('app_name_dir', $a2c_app_id) . ' ' . get_field('app_otchestvo_dir', $a2c_app_id) . ' ' . get_field('app_second_name_dir', $a2c_app_id);
    $fio_dir = trim($fio_dir2);
    unset($fio_dir2);

    $app_status = $a2c_app_status;

    $nomination = '"' . get_field('app_nomination', $a2c_app_id) . '"';
    $app_activity_place = trim(get_field('app_activity_place', $a2c_app_id));
    $app_class = trim(get_field('app_class', $a2c_app_id));
    if (!empty($app_activity_place) && !empty($app_class)) :
        $app_edu = '(' . get_field('app_activity_place', $a2c_app_id) . ', ' . get_field('app_class', $a2c_app_id) . ')';
    elseif (!empty($app_activity_place) && empty($app_class)) :
        $app_edu = '(' . get_field('app_activity_place', $a2c_app_id) .')';
    else: $app_edu = '';
    endif;
    unset($app_activity_place);
    unset($app_class);

    $app_post_dir = get_field('app_post_dir', $a2c_app_id);

    if (!empty($app_post_dir)) :
        $app_post_dir = '(' . $app_post_dir . ')';
    else: $app_post_dir = '';
    endif;  
    
    $id_concurs = get_field('app_id_concurs', $a2c_app_id);

    if( have_rows('diploma', $id_concurs) ):
    while ( have_rows('diploma', $id_concurs) ) : 
        the_row(); 
        $diploma_status = get_sub_field('diploma_status');

        if ($diploma_status == $app_status) :
            $diploma_party_img = get_sub_field('diploma_party_img');
            $diploma_party_img = (empty($diploma_party_img)) ? $white_base64 : $diploma_party_img;
            $type = pathinfo($diploma_party_img, PATHINFO_EXTENSION);
            $data = file_get_contents($diploma_party_img);
            $base64_party = 'data:image/' . $type . ';base64,' . base64_encode($data);
            unset($type);
            unset($data);   
            unset($diploma_party_img);  
            $diploma_text_before_fio = get_sub_field('diploma_text_before_fio');    
            $diploma_text_before_nomination = get_sub_field('diploma_text_before_nomination');

            $diploma_dir_img = get_sub_field('diploma_dir_img');
            $diploma_dir_img = (empty($diploma_dir_img)) ? $white_base64 : $diploma_dir_img;
            $type_dir = pathinfo($diploma_dir_img, PATHINFO_EXTENSION);
            $data_dir = file_get_contents($diploma_dir_img);
            $base64_dir = 'data:image/' . $type_dir . ';base64,' . base64_encode($data_dir);
            unset($type_dir);
            unset($data_dir);   
            unset($diploma_dir_img);
            $diploma_text_before_fio_dir = get_sub_field('diploma_text_before_fio_dir');
            $diploma_text_before_fio_party = get_sub_field('diploma_text_before_fio_party');
            $diploma_text_before_nomination_dir = get_sub_field('diploma_text_before_nomination_dir');

            $diploma_text_after_stamp = get_sub_field('diploma_text_after_stamp');  
            $diploma_footer = get_sub_field('diploma_footer');  
            if ($app_status == 'Оценена') : 
                $str = 'Сертификат участника';
                $str_dir = 'Сертификат руководителя'; 
            elseif ($app_status == '1 место' || $app_status == '2 место' || $app_status == '3 место') :
                $str = 'Диплом';
                $str_dir = 'Благодарственное письмо руководителя';
            endif;    
            $result = '<div id=last-div>';
            $result .= '<p class="title-row">' . $str .'</p>';
            $result .= "<p id=diploma_data data-app-id='" . $a2c_app_id . "' data-status='" . $app_status . "' data-img='" . $base64_party . "' data-text_before_fio='" . $diploma_text_before_fio . "' data-text_before_nomination='" . $diploma_text_before_nomination . "' data-text_after_stamp='" . $diploma_text_after_stamp . "' data-footer='" . $diploma_footer . "' data-fio='" . $fio . "' data-nomination='" . $nomination . "' data-edu='" . $app_edu . "' data-post_dir='" . $app_post_dir . "' data-fio_dir='" . $fio_dir . "' data-img_dir='" . $base64_dir . "'  data-diploma_text_before_fio_dir='" . $diploma_text_before_fio_dir . "' data-diploma_text_before_fio_party='" . $diploma_text_before_fio_party . "' data-diploma_text_before_nomination_dir='" . $diploma_text_before_nomination_dir . "'><a href=# id=ser_uch_open>Открыть</a> / <a href=# id=ser_uch_download>Скачать</a></p>";

            if (!empty($fio_dir)) : 
                $result .= '<p class="title-row">' . $str_dir . '</p>';
                $result .= '<p><a href=# id=ser_dir_open>Открыть</a> / <a href=# id=ser_dir_download>Скачать</a></p>';
            endif;

            $result .= '</div>';
            unset($diploma_status);
            unset($diploma_party_img);
            unset($diploma_party_img);
            unset($base64_party);
            unset($diploma_text_before_fio);
            unset($diploma_text_before_nomination);
            unset($diploma_text_before_fio_dir);
            unset($diploma_text_before_fio_party);
            unset($diploma_text_before_nomination_dir);
            unset($diploma_text_after_stamp);
            unset($str);
            unset($str_dir);

        endif; 
    endwhile;
endif;
unset($app_status);
unset($fio);
unset($fio_dir);
unset($app_edu);
unset($app_post_dir);
unset($white_base64);
unset($id_concurs);
unset($is_summarizing);

return $result;
}


