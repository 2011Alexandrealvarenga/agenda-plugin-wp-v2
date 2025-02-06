<?php 
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