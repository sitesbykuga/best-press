<?php
function child_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'this-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0.2' );
	wp_enqueue_style( 'bootstrap',  get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'concurs',  get_stylesheet_directory_uri() . '/assets/css/concurs.css', array(), '1.15' );
}
add_action( 'wp_enqueue_scripts', 'child_styles', 100 );

function child_scripts() {
	wp_enqueue_script( 'jquery',  get_stylesheet_directory_uri() . '/assets/js/jquery-3.3.1.min.js' );
	wp_enqueue_script( 'tabs',  get_stylesheet_directory_uri() . '/assets/js/tabs.js' );
	wp_enqueue_script( 'script',  get_stylesheet_directory_uri() . '/assets/build/script.js', array(), '2' );

	$data = get_data_application();
	$rating = get_rating_application();
	wp_localize_script( 'script', 'dataConcurs', $data );
	wp_localize_script( 'script', 'ratingConcurs', $rating );
	wp_enqueue_script( 'cf7-app',  get_stylesheet_directory_uri() . '/assets/js/cf7-app.js', array(), '1.0.27' );
	wp_enqueue_script( 'cf7-rating',  get_stylesheet_directory_uri() . '/assets/js/cf7-rating.js', array(), '1.0.27' );

	$studio = get_studio();
	wp_localize_script( 'script', 'listStudio', $studio );
	wp_enqueue_script( 'a2c-form-res',  get_stylesheet_directory_uri() . '/assets/js/a2c_form_res.js', array(), '1.4' );

	$event = get_event();
	wp_localize_script( 'script', 'listEvent', $event );
	wp_enqueue_script( 'a2c-form-event',  get_stylesheet_directory_uri() . '/assets/js/a2c_form_event.js', array(), '1.1' );

	wp_enqueue_script( 'rcl-clear-pass',  get_stylesheet_directory_uri() . '/assets/js/rcl_clear_pass.js', array(), '1.7' );
}
add_action( 'wp_footer', 'child_scripts'); 

function delete_your_subject($post_id){
	global $wpdb;
	
	$cfdb = apply_filters( 'cfdb7_database', $wpdb );
    $table_name_app = $cfdb->prefix.'db7_forms_app';
	
	$wpdb->delete( $table_name_app, array('your-subject' => $post_id) );
}

add_action( 'before_delete_post', 'delete_concurs' );
function delete_concurs( $post_id ){
	$post = get_post( $post_id );
	if( ! $post || $post->post_type !== 'concurs' ) 
		return;
	delete_your_subject($post_id);
	return;
}

add_action( 'save_post_concurs', 'set_data_application');
function set_data_application($post_id){

	$data = array();
	$null = NULL;
		if( have_rows('order_nomination', $post_id) ): 
			while ( have_rows('order_nomination') ) : 
				the_row();
				/*$fields = get_sub_field_object('nomination_filetype');
				$filetypes = $fields['value'];
				$filetype = join(',', $filetypes);*/
				array_push($data, array(get_field('concurs_title',$post_id), 'nomination', get_sub_field('nomination_name', $post_id), $null, $null/*, $filetype*/)); 
			endwhile;
		endif;

		$rating_access = get_field_object('rating_access',$post_id);
		$rat_access = $rating_access['value'];
		$r_access = array();
		foreach ($rat_access as $key) :
			array_push($r_access, $rating_access['choices'][ $key ]);
		endforeach;
		$access = join('*+*', $r_access);
		array_push($data, array(get_field('concurs_title',$post_id), 'rating_access', $access, $null, $null));

		$rating_point = get_field_object('rating_point',$post_id);
		$rat_point = $rating_point['value'];
		$r_point = array();
		foreach ($rat_point as $key) :
			array_push($r_point, $rating_point['choices'][ $key ]);
		endforeach;
		$point = join('*+*', $r_point);
		array_push($data, array(get_field('concurs_title',$post_id), 'rating_point', $point, $null, $null));

		if( have_rows('order_theme', $post_id) ): 
			while ( have_rows('order_theme') ) : 
				the_row(); 
				$theme_group_title = get_sub_field('theme_group_title', $post_id);
				$date_begin_accept = get_sub_field('date_begin_accept', $post_id);
				$date_end_accept = get_sub_field('date_end_accept', $post_id);
				if( have_rows('order_themes', $post_id) ): 
					while ( have_rows('order_themes') ) : 
						the_row();
						array_push($data, array(get_field('concurs_title',$post_id)
												, $theme_group_title
												, get_sub_field('theme_title', $post_id)
												, $date_begin_accept
												, $date_end_accept
												// $null
											)
						);
					endwhile;
				endif;	
			endwhile;
		endif;

	delete_your_subject($post_id);

	global $wpdb;
	
	$cfdb = apply_filters( 'cfdb7_database', $wpdb );
    $table_name_app = $cfdb->prefix.'db7_forms_app';
	
	foreach($data as $d) :
		$cfdb->insert( $table_name_app, array(
            'concurs' => $d[0],
            'nomination' => $d[1],
            'theme' => $d[2],
            'your-subject' => $post_id,
            /*'filetype' => $d[5],*/
            'name' => $d[3],
            'name_party' => $d[4]
        ) );
    endforeach;

	return $data;
}

/*Получение $data для формы подачи заявки*/
function get_data_application(){
	global $wpdb;
	$concurs = $wpdb->get_results("select distinct concurs from wp_db7_forms_app where `your-subject` in (select distinct concat(post_id,'') from wp_postmeta where meta_key like 'summarizing' and meta_value = 0)");
	$nomination = $wpdb->get_results("select distinct concurs, theme from wp_db7_forms_app where nomination like 'nomination' and `your-subject` in (select distinct concat(post_id,'') from wp_postmeta where meta_key like 'summarizing' and meta_value = 0)");
	$theme = $wpdb->get_results("select distinct concurs, nomination, theme, name, name_party from wp_db7_forms_app where nomination not like 'nomination' and nomination not like 'rating_access' and nomination not like 'rating_point' and `your-subject` in (select distinct concat(post_id,'') from wp_postmeta where meta_key like 'summarizing' and meta_value = 0)");
	$group = $wpdb->get_results("select distinct concurs, nomination, name, name_party from wp_db7_forms_app where nomination not like 'nomination' and nomination is not null and nomination not like '' and nomination not like 'rating_access' and nomination not like 'rating_point' and `your-subject` in (select distinct concat(post_id,'') from wp_postmeta where meta_key like 'summarizing' and meta_value = 0)");
	$data = array('concurs' => $concurs
				, 'nomination' => $nomination
				, 'theme' => $theme
				, 'group' => $group);

	return $data;
}

function get_rating_application(){
	global $wpdb;
	$rating = $wpdb->get_results("select distinct concurs, nomination, theme from wp_db7_forms_app where nomination like 'rating_access' or nomination like 'rating_point'");
	return $rating;
}




function get_studio(){
	$fields = CFS()->get( 'form_res_list_studio', 5517 );
	$list = array();
	foreach ( $fields as $field ) {
    	array_push($list, $field['form_res_studio']);
	}

	return $list;
}

function get_event(){
	$fields = CFS()->get( 'form_event_list_title', 5702 );
	$list = array();
	foreach ( $fields as $field ) {
    	array_push($list, $field['form_event_title']);
	}

	return $list;
}

function my_deregister_javascript(){
	$pages = array(
		is_singular('concurs'),
		is_page('account'),
		is_singular('application'),
		is_page('kontakty')
	);
	if( ! in_array(true, $pages) ){
		wp_deregister_script( 'contact-form-7' ); // отключаем скрипты плагина
		wp_deregister_style( 'contact-form-7' ); // отключаем стили плагина
	}
}
add_action('wp_print_styles', 'my_deregister_javascript', 100 );

function my_deregister_javascript_cf7_app(){
	$cf7_app = array(
		is_page('account'),
		is_singular('concurs')
	);
	if( ! in_array(true, $cf7_app) ){
		wp_deregister_script( 'cf7-app' ); 
	}
	$cf7_rating = array(
		is_page('account'),
		is_singular('application')
	);
	if( ! in_array(true, $cf7_rating) ){
		wp_deregister_script( 'cf7-rating' ); 
	}
}
add_action('wp_print_scripts', 'my_deregister_javascript_cf7_app', 100 );

function custom_posts_per_page($query){
if(is_post_type_archive('application')){ $query->set('posts_per_page',100); }
}
add_action('pre_get_posts','custom_posts_per_page');

add_filter( 'get_the_archive_title', function( $title ){
	return preg_replace('~^[^:]+: ~', '', $title );
});

// создаем новую колонку
add_filter( 'manage_'.'application'.'_posts_columns', 'add_app_id_column', 4 );
function add_app_id_column( $columns ){
	$num = 2; // после какой по счету колонки вставлять новые
	$new_columns = array(
		'app_id_app' => '№ заявки',
	);
	return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}
// заполняем колонку данными
// wp-admin/includes/class-wp-posts-list-table.php
add_action('manage_'.'application'.'_posts_custom_column', 'fill_app_id_column', 5, 2 );
function fill_app_id_column( $colname, $post_id ){
	if( $colname === 'app_id_app' ){
		echo get_post_meta( $post_id, 'app_id_app', 1 ); 
	}
}

/*Функции для изменения настроек рассылки через личный кабинет */
add_action('rcl_update_profile_fields', 'update_newsletter', 10, 1);
function update_newsletter($user_ID){
	global $wpdb;

	if (!empty($user_ID)){

		$user_meta = $wpdb->get_results("SELECT t.`meta_value` as first_name, t2.`meta_value` as last_name , t3.`meta_value` as user_newsletter, user_email FROM (select user_email, ID from wp_users where ID = " . $user_ID . ") t4 left join (select * from `wp_usermeta` where user_id = " . $user_ID . " and `meta_key` like 'last_name') t2 on t4.ID = t2.user_id left join (select * from `wp_usermeta` where user_id = " . $user_ID . " and `meta_key` like 'user_newsletter') t3 on t4.ID = t3.user_id join (select * from `wp_usermeta` where user_id = " . $user_ID . " and `meta_key` like 'first_name') t on t.user_id = t4.ID");
		$status = 'C';		

		foreach ($user_meta as $meta_field) {


			if (empty($meta_field->user_newsletter)) {
				$status = 'U';
			}

			$check_newsletter = $wpdb->get_results("SELECT count(*) ch from wp_newsletter where wp_user_id = ". $user_ID);

			if (!empty($check_newsletter[0])) {
				$wpdb->update('wp_newsletter', array('name' => $meta_field->first_name, 'email' => $meta_field->user_email, 'status' => $status, 'surname' => $meta_field->last_name), array('wp_user_id' => $user_ID));
			}
			else {
				$u = array('name' => $meta_field->first_name
					, 'email' => $meta_field->user_email
					, 'status' => $status
					, 'surname' => $meta_field->last_name
					, 'wp_user_id' => $user_ID
				);	
				$u['token'] = NewsletterModule::get_token();
				$r = $wpdb->insert('wp_newsletter', $u);
			}
		}
	}
}

add_action('newsletter_unsubscribed', 'delete_user_newsletter', 10, 1);
function delete_user_newsletter($user){
	delete_user_meta($user->wp_user_id, 'user_newsletter');
}

add_action('newsletter_user_confirmed', 'update_user_newsletter', 100, 1);
function update_user_newsletter($user){
	$var = unserialize('a:1:{i:0;s:38:"Согласие на рассылку";}'); 
	update_user_meta($user->wp_user_id, 'user_newsletter', $var );
}



