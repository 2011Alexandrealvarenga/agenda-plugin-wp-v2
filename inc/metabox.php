<?php 
// metabox
function criar_campo_personalizado_agenda() {

  add_meta_box(
      'local_value', 
      'Local dados', 
      'exibir_campo_local_value', 
      'agenda', 
      'normal', 
      'high' 
  );

}
add_action('add_meta_boxes', 'criar_campo_personalizado_agenda');

function exibir_campo_local_value($post) {
  $local_value = get_post_meta($post->ID, '_local_value', true);
  $data_evento = get_post_meta($post->ID, '_data_evento', true);
  $horario_inicio = get_post_meta($post->ID, '_horario_inicio', true);
  $horario_final = get_post_meta($post->ID, '_horario_final', true);

?>

  <label for="local_value">Local:</label>
  <input type="text" name="local_value" value="<?php echo esc_attr($local_value); ?>" class="widefat" />
  <br>

  <label for="data_evento">Data:</label>
  <input type="date" name="data_evento" value="<?php echo esc_attr($data_evento); ?>" class="widefat" />
  <br>

  <label for="horario_inicio">Horário de inicio:</label>
  <input type="time" name="horario_inicio" value="<?php echo esc_attr($horario_inicio); ?>" class="widefat" />
  <br>

  <label for="horario_final">Horário de inicio:</label>
  <input type="time" name="horario_final" value="<?php echo esc_attr($horario_final); ?>" class="widefat" />
  <br>

  <?php
}

function salvar_campo_local_value($post_id) {
  if (isset($_POST['local_value'])) {
      update_post_meta($post_id, '_local_value', sanitize_text_field($_POST['local_value']));
  }

  if (isset($_POST['data_evento'])) {
    update_post_meta($post_id, '_data_evento', sanitize_text_field($_POST['data_evento']));
  }

  if (isset($_POST['horario_inicio'])) {
    update_post_meta($post_id, '_horario_inicio', sanitize_text_field($_POST['horario_inicio']));
  }

  if (isset($_POST['horario_final'])) {
    update_post_meta($post_id, '_horario_final', sanitize_text_field($_POST['horario_final']));
  }
}
add_action('save_post', 'salvar_campo_local_value');

