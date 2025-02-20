<?php
/*
Plugin Name: Agenda Plugin v2
Description: esta funcionando mas com data da publicação e não do metabox
Version: 1.0
Author: Seu Nome
*/

include('functions.php');

include('inc/post-type.php');


function agenda_shortcode() {
    ob_start();
    
    ?>
    <div class="content-agenda">

        <div class="content-arrow">
            <div class="btn-arrow mg-r8">
                <img src="<?php echo plugin_dir_url(__FILE__); ?>/assets/img/arrow-left.svg" id="check-previous-day" class="icon-arrow">
            </div>

            <input type="text" id="agenda-datepicker" class="mg-r8" readonly>

            <div class="btn-arrow mg-r8">
                <img src="<?php echo plugin_dir_url(__FILE__); ?>/assets/img/arrow-right.svg" id="check-next-day" class="icon-arrow">
            </div>            
        </div>
        <h2 class="subtitle">Últimos Eventos</h2>
        <div id="agenda-posts">
            <?php
            $args = array(
                'post_type' => 'agenda',
                'posts_per_page' => 10,
                'orderby' => 'meta_value', 
                'order' => 'DESC', 
                'meta_key' => '_data_evento',
                'meta_type' => 'DATE' 
            );
            $query = new WP_Query($args);
    
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $evento_data = get_post_meta(get_the_ID(), '_data_evento', true);
                    $local_value = get_post_meta(get_the_ID(), '_local_value', true);
                    $horario_inicio = get_post_meta(get_the_ID(), '_horario_inicio', true);
                    $horario_final = get_post_meta(get_the_ID(), '_horario_final', true);
                    if ($evento_data) {
                        $evento_data_formatada = date('d/m/Y', strtotime($evento_data)); // Formata a data do evento
                    }
                    ?>

                   <?php include('template-parts/content-item.php');?>

                    <?php
                }
            } else {
                echo '<p>Sem eventos programados para este dia </p>';
            }
            wp_reset_postdata();
            ?>
            <div id="agenda-result"></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('agenda', 'agenda_shortcode');



function check_specific_day_posts() {
    if (isset($_POST['date'])) {
        $date = sanitize_text_field($_POST['date']);
        $args = array(
            'post_type' => 'agenda',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key'     => '_data_evento', 
                    'value'   => date('Y-m-d', strtotime($date)),
                    'compare' => '='
                ),
            ),
        );
        $query = new WP_Query($args);?>

        <p><b><?php echo date_i18n('j \d\e F \d\e Y', strtotime($date));?></b></p>

        <!-- date_i18n('j \d\e F', strtotime($evento_data)) -->
         <?php 
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();?>
                <!-- get agenda content -->
                <?php 
                        $evento_data = get_post_meta(get_the_ID(), '_data_evento', true);
                        $local_value = get_post_meta(get_the_ID(), '_local_value', true);
                        $horario_inicio = get_post_meta(get_the_ID(), '_horario_inicio', true);
                        $horario_final = get_post_meta(get_the_ID(), '_horario_final', true);
                    ;?>

                    <?php include('template-parts/content-item.php');?>
               <?php 

            }
        } else {
            echo '<p>Sem eventos programados para este dia</p>';
        }
        wp_reset_postdata();
    }
    wp_die();
}

add_action('wp_ajax_check_specific_day_posts', 'check_specific_day_posts');
add_action('wp_ajax_nopriv_check_specific_day_posts', 'check_specific_day_posts');

