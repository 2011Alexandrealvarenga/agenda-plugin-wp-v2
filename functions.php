<?php 

// metabox
include('inc/metabox.php');

function agenda_enqueue_scripts() {
  // Carrega o jQuery que já vem com o WordPress
  wp_enqueue_script('jquery');

  // Carrega o jQuery UI Datepicker
  wp_enqueue_script('jquery-ui-datepicker');

  // Carrega o estilo do jQuery UI Datepicker
  wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

  // Adiciona o script personalizado que depende do jQuery
  wp_enqueue_script('agenda-script', plugin_dir_url(__FILE__) . 'assets/js/agenda-script.js', array('jquery', 'jquery-ui-datepicker'), null, true);

  // Passa a URL do admin-ajax.php para o script JavaScript
  wp_localize_script('agenda-script', 'agenda_ajax', array(
      'ajax_url' => admin_url('admin-ajax.php')
  ));


}
add_action('wp_enqueue_scripts', 'agenda_enqueue_scripts');


function agenda_enqueue_css(){
    
    wp_register_style(
        'agenda_style',
        plugin_dir_url(__FILE__) .'/assets/css/style-plugin.css'
    );

    wp_enqueue_style('agenda_style');
}


add_action('wp_enqueue_scripts', 'agenda_enqueue_css');


// se os posts forem do tipo posts, carrega os o arquivo single-agenda
function meu_plugin_incluir_template_agenda($template) {
    // Verifica se é um post do tipo "agenda"
    if (is_singular('agenda')) {
        // Caminho para o arquivo template no seu plugin
        $plugin_template = plugin_dir_path(__FILE__) . 'single-agenda.php';
        
        // Verifica se o arquivo existe no plugin e retorna o caminho do arquivo
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
  
    // Retorna o template padrão caso não seja um post do tipo "agenda"
    return $template;
  }
  
//   add_filter('template_include', 'meu_plugin_incluir_template_agenda');
