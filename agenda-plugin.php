<?php
/*
Plugin Name: Agenda Plugin v2
Description: esta funcionando mas com data da publicação e não do metabox
Version: 1.0
Author: Seu Nome
*/

// Função para registrar o CPT 'agenda_nova'
include('functions.php');

// Registrar o Custom Post Type 'Agenda'
function agenda_register_post_type() {
    $labels = array(
        'name'               => 'Agendas',
        'singular_name'      => 'Agenda',
        'menu_name'          => 'Agendas',
        'name_admin_bar'     => 'Agenda',
        'add_new'            => 'Adicionar Nova',
        'add_new_item'       => 'Adicionar Nova Agenda',
        'new_item'           => 'Nova Agenda',
        'edit_item'          => 'Editar Agenda',
        'view_item'          => 'Ver Agenda',
        'all_items'          => 'Todas as Agendas',
        'search_items'       => 'Pesquisar Agendas',
        'parent_item_colon'  => 'Agendas Pai:',
        'not_found'          => 'Nenhuma agenda encontrada.',
        'not_found_in_trash' => 'Nenhuma agenda encontrada na lixeira.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'agenda' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'agenda', $args );
}
add_action( 'init', 'agenda_register_post_type' );

function agenda_shortcode() {
    ob_start();
    ?>
    <!-- Botões para navegar entre dias -->
    <button id="check-previous-day">Verificar posts do dia anterior</button>
    <button id="check-next-day">Verificar posts do dia posterior</button>

    <!-- Campo de entrada para o calendário -->
    <div>
        <label for="agenda-datepicker">Selecione uma data:</label>
        <input type="text" id="agenda-datepicker" readonly>
    </div>
    <div id="agenda-posts">
        <?php
        // Carrega os últimos 10 posts ao acessar a página
        $args = array(
            'post_type' => 'agenda',
            'posts_per_page' => 10,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <div class="agenda-post">
                    <span><a href="<?php echo get_permalink() ;?>"><?php echo get_the_title() ;?></a></span>
                    <div><?php the_content(); ?></div>
                    <small>Publicado em: <?php the_date(); ?></small>
                </div>
                <hr>
                <?php
            }
        } else {
            echo '<p>Nenhum post encontrado.</p>';
        }
        wp_reset_postdata();
        ?>
    </div>

    

    <!-- Área de resultados -->
    <div id="agenda-result"></div>
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
            'date_query' => array(
                array(
                    'year'  => date('Y', strtotime($date)),
                    'month' => date('m', strtotime($date)),
                    'day'   => date('d', strtotime($date)),
                ),
            ),
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo '<div class="agenda-post">';
                echo '<span><a href="' . get_permalink() . '">' . get_the_title() . '</a></span>'; // Link no título
                echo '<div>' . get_the_content() . '</div>';
                echo '<small>Publicado em: ' . get_the_date() . '</small>';
                echo '</div>';
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

