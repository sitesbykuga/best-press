<?php 
add_action('init','add_tab_application');

function add_tab_application(){

    $user = wp_get_current_user();

    $content = array(
                    array( 
                        'id' => 'app-subtab-1', 
                        'name' => 'Мои заявки', 
                        'icon' => 'fa-address-book-o', 
                        'callback' => array(
                            'name'=>'application_function'
                        )
                    ),
                    array( 
                        'id' => 'app-subtab-2', 
                        'name' => 'Подать заявку', 
                        'icon' => 'fa-edit', 
                        'callback' => array(
                            'name'=>'application_function_send'
                        )
                    )
                );

    $tab_data =	array(
        'id'=>'application', 
        'name'=>'Заявки', 
        'public'=>0, 
        'icon'=>'fa-address-card-o', 
        'output'=>'menu', 
        'content'=> $content
    );
 
    rcl_tab($tab_data);
 
}

function application_function_send(){
    return do_shortcode('[contact-form-7 id="3241" title="Подать заявку"]');
}

function application_function(){

    $cur_user_id = get_current_user_id();
    $args = array(
        'post_type' => 'application'
        , 'author' => $cur_user_id
        , 'showposts' => -1
    );

    $query = new WP_Query( $args );
    unset($args);
    unset($cur_user_id);
    $srt = '<section id="primary" class="content-archive content-area">';
    $str .= '<main id="main" class="site-main" role="main">'; 
    $str .= '<div class="container">'; 
    if ( $query->have_posts() ) {
        $str .= '<div class="row app-status">';
        $str .= '<div><span style="color:#F8B72F; font-size: 14px;"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>&nbsp;-&nbsp;заявка отправлена на конкурс;&#8195;<span style="color:#6BC641; font-size: 14px;"><i class="fa fa-check-circle" aria-hidden="true"></i></span>&nbsp;-&nbsp;заявка допущена к участию в конкурсе;&#8195;<span style="color:#274D91; font-size: 12px; border-radius: 50%; border: 1px solid #274D91; padding: 2px;"><b>8.45</b></span>&nbsp;-&nbsp;средний балл среди выставленных оценок;&#8195;<span style="color:#274D91; font-size: 14px;"><i class="fa fa-trophy" aria-hidden="true"></i></span>&nbsp;-&nbsp;работа является победителем (призером) конкурса;&#8195;<span style="color:red; font-size: 14px;"><i class="fa fa-times-circle" aria-hidden="true"></i></span>&nbsp;-&nbsp;заявка отклонена;&#8195;<span style="color:#583B7A; font-size: 14px;"><i class="fa fa-commenting" aria-hidden="true"></i></span>&nbsp;-&nbsp;организатор оставил комментарий к работе';
        $str .= '</div></div>';     
        $str .= '<div class="row">'; 
        $str .= '<div class="col-lg-1 col-md-unhide"><b>Статус</b></div>'; 
        $str .= '<div class="col-lg-1 col-md-unhide"><b>Номер</b></div>'; 
        $str .= '<div class="col-lg-2 col-md-unhide"><b>Дата</b></div>'; 
        $str .= '<div class="col-lg-3 col-md-unhide"><b>Название работы</b></div>'; 
        $str .= '<div class="col-lg-5 col-md-unhide"><b>Конкурс - Номинация (Возрастная группа)</b></div>'; 
        /*$str .= '<div class="col-lg-3 col-md-unhide"><b>Номинация</b></div>'; */
        $str .= '</div> ';

        while ( $query->have_posts() ) {
            $query->the_post();
            $str .= load_template_part( 'template-parts/content-application' );
        }
    } else {
        $str .= '<h3>От Вас пока не поступило ни одной заявки</h3>'; 
    }
    $str .= '</div>'; 
    $str .= '</main>'; 
    $str .= '</section>'; 
    return $str;
}


function load_template_part($template_name, $part_name=null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

function memoryUsage($usage, $base_memory_usage) {
printf("Bytes diff: %d\n", $usage - $base_memory_usage);
}
function someBigValue() {
return str_repeat('SOME BIG STRING', 1024);
}