<?php 
      $evento_data = get_post_meta(get_the_ID(), '_data_evento', true);
      $local_value = get_post_meta(get_the_ID(), '_local_value', true);
      $horario_inicio = get_post_meta(get_the_ID(), '_horario_inicio', true);
      $horario_final = get_post_meta(get_the_ID(), '_horario_final', true);
  ;?>

<div class="agenda-post">
  <div class="content-inside">
      <div class="data-left">
          <span>02</span>
          <span class="month">fev</span>
      </div>
      <div class="content-date">                                
          <span class="local"><span class="local"><?php echo date('H:i', strtotime($horario_inicio));?></span> - <span class="local"><?php echo date('H:i', strtotime($horario_final));?></span>
          <h3 class="title"><?php echo get_the_title() ;?></h3>
          <span class="local"><?php echo $local_value;?></span>    
      </div>
  </div>
</div>