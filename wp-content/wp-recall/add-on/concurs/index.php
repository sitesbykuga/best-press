<?php 
add_action('init','add_tab_concurs');

function add_tab_concurs(){

    $user = wp_get_current_user();

    $content = array();

    array_push($content, array( 
        'id' => 'app-subtab-3',
        'name' => 'Все заявки',
        'icon' => 'fa-edit',
        'callback' => array(
            'name'=>'application_function_admin',
            )
        )
    );

    array_push($content, array( 
        'id' => 'app-subtab-4',
        'name' => 'Конкурсы',
        'icon' => 'fa-trophy',
        'callback' => array(
            'name'=>'concurs_function_admin',
            )
        )
    );

    $tab_data =	array(
        'id'=>'concurs', 
        'name'=>'Конкурсы', 
        'public'=>0, 
        'icon'=>'fa-address-card-o', 
        'output'=>'menu', 
        'content'=> $content
    );

    if (in_array('administrator', $user->roles) || in_array('juri', $user->roles)) :
        rcl_tab($tab_data);
    endif;
}

function application_function_admin(){

    $srt = '<section id="primary" class="content-archive content-area">';
    $str .= '<main id="main" class="site-main" role="main">'; 
    $str .= '<div class="container">'; 

    $args = array(
        'post_type' => 'application',
        'posts_per_page' => -1/*,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'app_concurs',
                'value' => 'blue'
            ),
            array(
                'key' => 'app_nomination',
                'value' => 20
            ),
            array(
                'key' => 'app_age',
                'value' => 20
            )
        )*/
    );

    $query = new WP_Query( $args );


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
        /*$str .= '<div class="col-lg-3 col-md-unhide"><b>Номинация (Возрастная группа)</b></div>'; */
        $str .= '</div> '; 

        while ( $query->have_posts() ) {
            $query->the_post();
            $str .= load_template_part2( 'template-parts/content-application' );
        }
    } else {
        $str .= '<h3>От Вас пока не поступило ни одной заявки</h3>'; 
    }
    
    $str .= '</div>'; 
    $str .= '</main>'; 
    $str .= '</section>'; 

    return $str;
}

function load_template_part2($template_name, $part_name=null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

function concurs_function_admin() {

    $args = array(
        'post_type' => 'concurs',
        'posts_per_page' => -1
    );

    $query = new WP_Query( $args );
    $srt = '<section id="primary" class="content-archive content-area">';
    $str .= '<main id="main" class="site-main" role="main">'; 
    $str .= '<div class="container" id="a2c">'; 

    if ( $query->have_posts() ) { 
        $str .= '<div class="row" style="margin:20px 0 40px 0;">';
        $str .= '<a href="#" class="button-app-dip link-button tabs-menu">Проверка сертификата</a>';
        $str .= '</div>';   
        
        $str .= '<div class="row">';  
        $str .= '<div class="col-lg-3 col-md-unhide"><b>Конкурс</b></div>';  
        $str .= '<div class="col-lg-3 col-md-unhide"><b>Прием заявок</b></div>';  
        $str .= '<div class="col-lg-3 col-md-unhide"><b>Работа жюри</b></div>';  
        $str .= '<div class="col-lg-3 col-md-unhide"><b>Итоги</b></div>';  
        $str .= '</div>';   
            
    while ( $query->have_posts() ) {
            $query->the_post();
            $str .= load_template_part2( 'template-parts/content-concurs-lk' );
        }
    } else {
        $str = '<h3>Ни одного конкурса не зарегистрировано</h3>'; 
    }
    $str .= '<div class="popup-app-list" style="display:none">';
    $str .= '<button class=popup-close>&times;</button>';
    $str .= '<div class="popup-content popup-content-list">';    
    $str .= '<h2 style="margin:10px 10px 30px 10px;">Выберете поля, необходимые для формирования списка участников</h2>';
    $str .= '<div class=container><div class=row style="text-align: left"><div class=input-list>';
    $field_list = array(
        array('app_npp', '№ п/п', true)
        , array('app_second_name_party', 'Фамилия участника', true)
        , array('app_name_party', 'Имя участника', true)
        , array('app_otch_party', 'Отчество участника', true)
        , array('app_fio_party', 'ФИО участника', false, true)
        , array('group', 'Заявка', true)
        , array('app_id_app', '№ заявки', true)
        , array('app_date', 'Дата подачи', true)
        , array('app_title', 'Наименование работы', true)
        , array('app_concurs', 'Конкурс', true)
        , array('app_nomination', 'Номинация', true)
        , array('app_theme', 'Тема', true)
        , array('app_free_theme', 'Cвободная тема', true)
        , array('app_age_group', 'Возрастная категория', true)
        , array('app_point_avg', 'Средний балл', true)
        , array('app_status', 'Статус заявки', true)
        , array('group', 'Участник', true)        
        , array('app_birthday', 'Дата рождения', true)
        , array('app_age', 'Возраст на момент подачи заявки', true)
        , array('app_tel_party', 'Телефон участника', true)
        , array('app_email', 'E-mail участника', false)
        , array('app_link_social', 'Социальные сети', false)
        , array('app_activity_place', 'Место учебы', false)
        , array('app_class', 'Класс', false)
        , array('app_edu', 'Образование', false)
        , array('app_hobby', 'Хобби', false)
        , array('app_region', 'Место проживания. Регион', false)
        , array('app_city', 'Место проживания. Город/Район', false)
        , array('app_np', 'Место проживания. Район города/Населенный пункт', false)
        , array('group', 'Законный представитель', true)
        , array('app_second_name_pr', 'Фамилия представителя', false)
        , array('app_name_pr', 'Имя представителя', false)
        , array('app_otchestvo_pr', 'Отчество представителя', false)
        , array('app_fio_pred', 'ФИО представителя', false, true)
        , array('app_tel_pr', 'Телефон представителя', false)
        , array('app_email_pr', 'E-mail представителя', false)
        , array('group', 'Руководитель', true)
        , array('app_second_name_dir', 'Фамилия руководителя', false)
        , array('app_name_dir', 'Имя руководителя', false)
        , array('app_otchestvo_dir', 'Отчество руководителя', false)
        , array('app_fio_dir', 'ФИО руководителя', false, true)
        , array('app_post_dir', 'Место работы и занимаемая должность', false)
        , array('app_tel_dir', 'Телефон руководителя', false)
        , array('app_email_dir', 'E-mail руководителя', false)
    );
    $str .= '<ul style="column-count:2">';
    foreach ($field_list as $k):
        if ($k[0] == 'group') :
            $str .= '<li style="margin-bottom: 5px;"><strong>' . $k[1] . '</strong></li>';
        else:             
            $str .= '<li style="list-style-type: none" ';
            if ($k[3]) :
                $str .= 'hidden=' . $k[3];
            endif;
            $str .= '><input class="list-input" type=checkbox name="' . $k[0] . '" ';
            if ($k[2]) :
                $str .= 'checked ';
            endif;            
            $str .= '>' . $k[1] . "</li>";
        endif;        
    endforeach;
    $str .= '</ul>';

    $str .= '<button class="btn_list_party">Сформировать список</button>';

    $str .= '</div>';
    $str .= '</div>';
    $str .= '</div>';
    $str .= '</div>';
    $str .= '</div>';

    $str .= '<div class="popup-app-dip" style="display:none">';
    $str .= '<button class=popup-close>&times;</button>';
    $str .= '<div class="popup-content-dip popup-content" id=pdfmake-link>';    
    $str .= '<h2 style="margin:10px 10px 30px 10px;">Тестирование сертификатов и дипломов участников и их руководителей</h2>';
    $str .= '<div class=container><div class=row style="text-align: center; display: block">';
    $str .= '<p><span>Проверка для заявки: #</span> <input type=text id="app-id"></p> <br>';
    $str .= '<p><span>Статус: </span> <select id="app-status"><option>Оценена</option><option>1 место</option><option>2 место</option><option>3 место</option></select></p> <br>';

    $str .= '<button class="btn_dip">Сформировать сертификат</button>';

    $str .= '</div>';
    $str .= '</div>';
    $str .= '</div>';
    $str .= '</div>';

    return $str;
}
