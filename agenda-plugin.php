<?php
/*
Plugin Name: Agenda Plugin v2
Description: esta funcionando mas com data da publicação e não do metabox
Version: 1.0
Author: Seu Nome
*/

// Função para registrar o CPT 'agenda_nova'
include('functions.php');

include('inc/post-type.php');


function agenda_shortcode() {
    ob_start();
    ?>
    <div class="content-agenda">

        <button id="check-previous-day">Verificar posts do dia anterior</button>
        <button id="check-next-day">Verificar posts do dia posterior</button>
    
        <div>
            <label for="agenda-datepicker">Selecione uma data:</label>
            <input type="text" id="agenda-datepicker" readonly>
        </div>
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
                    ?>
                    <div class="agenda-post">
                        <span class="list 1"><a href="<?php echo get_permalink() ;?>"><?php echo get_the_title() ;?></a></span>
                        <span><?php the_content(); ?></span>
                        <?php 
                        $evento_data = get_post_meta(get_the_ID(), '_data_evento', true);
                        $local_value = get_post_meta(get_the_ID(), '_local_value', true);
                        $horario_inicio = get_post_meta(get_the_ID(), '_horario_inicio', true);
                        $horario_final = get_post_meta(get_the_ID(), '_horario_final', true);
    
                        ?>
                        <span>Horario de inicio: <?php echo $horario_inicio;?></span><br>
                        <span>Horario Final: <?php echo $horario_final;?></span><br>
                        <span>Local: <?php echo $local_value;?></span><br>
                        <span>Data do Evento: <?php echo date('d/m/Y', strtotime($evento_data));?></span><br>
    
                    </div>
                    <hr>
                    <?php
                }
            } else {
                echo '<p>Nenhum post encontrado.</p>';
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

        <p>Data: <?php echo date('d/m/Y', strtotime($date));?></p>
        
         <?php 
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post()?>
                <?php 
                $evento_data = get_post_meta(get_the_ID(), '_data_evento', true);
                $evento_data = get_post_meta(get_the_ID(), '_data_evento', true);
                $local_value = get_post_meta(get_the_ID(), '_local_value', true);
                $horario_inicio = get_post_meta(get_the_ID(), '_horario_inicio', true);
                $horario_final = get_post_meta(get_the_ID(), '_horario_final', true);
                
                ;?>
                <div class="agenda-post">
                    <span class="list 1"><a href="<?php echo get_permalink() ;?>"><?php echo get_the_title() ;?></a></span>
                    <span><?php the_content(); ?></span>
                    <span>Horario de inicio: <?php echo $horario_inicio;?></span><br>
                    <span>Horario Final: <?php echo $horario_final;?></span><br>
                    <span>Local: <?php echo $local_value;?></span><br>
                    <span>Data do Evento: <?php echo date('d/m/Y', strtotime($evento_data));?></span>
                </div>
                <hr>
               <?php 
            }
        } else {
            echo '<p>Nenhum post encontrado para o dia ' . date('d/m/Y', strtotime($date)) . '.</p>';
        }
        wp_reset_postdata();
    }
    wp_die();
}

add_action('wp_ajax_check_specific_day_posts', 'check_specific_day_posts');
add_action('wp_ajax_nopriv_check_specific_day_posts', 'check_specific_day_posts');

function agenda_enqueue_scripts() {
    // Carrega o jQuery que já vem com o WordPress
    wp_enqueue_script('jquery');

    // Carrega o jQuery UI Datepicker
    wp_enqueue_script('jquery-ui-datepicker');

    // Carrega o estilo do jQuery UI Datepicker
    wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

    // Adiciona o script personalizado que depende do jQuery
    wp_enqueue_script('agenda-script', plugin_dir_url(__FILE__) . 'agenda-script.js', array('jquery', 'jquery-ui-datepicker'), null, true);

    // Passa a URL do admin-ajax.php para o script JavaScript
    wp_localize_script('agenda-script', 'agenda_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'agenda_enqueue_scripts');

// asdf