<div class="agenda-post">
  <div class="content-inside">
      <div class="data-left">
          <span class="day"><?php echo date('d', strtotime($evento_data)); ?></span>
          <span class="month"><b><?php echo ucfirst(date_i18n('M', strtotime($evento_data))); ?></b></span>
          <span class="year"><b><?php echo date_i18n('Y', strtotime($evento_data));?></b></span>
      </div>
      <div class="content-date">                                 
          <span class="local"><span class="local"><?php echo date('H:i', strtotime($horario_inicio));?></span> - <span class="local"><?php echo date('H:i', strtotime($horario_final));?></span></span>
          <h3 class="title"><?php echo get_the_title(); ?></h3>
          <span class="local"><?php echo $local_value;?></span>    
      </div>
  </div>
</div>