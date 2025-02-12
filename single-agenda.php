<?php
/**
 * Template Single para o Post Type "Agenda"
 */

get_header(); 
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
                $evento_data = get_post_meta(get_the_ID(), '_data_evento', true);
                $local = get_post_meta(get_the_ID(), '_local_value', true);
                $horario_inicio = get_post_meta(get_the_ID(), '_horario_inicio', true);
                $horario_final = get_post_meta(get_the_ID(), '_horario_final', true);
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="agenda-post">
                    <div class="content-hour">
                        <span class="mg-r8"><?php echo $horario_inicio;?></span>
                        <hr>
                    </div>
                    <div class="content-inside">
                        <div class="content-date">                                
                            <span class="local"><?php echo date_i18n('j \d\e F', strtotime($evento_data));?></span> - <span class="local"><?php echo date('H:i', strtotime($horario_inicio));?></span> - <span class="local"><?php echo date('H:i', strtotime($horario_final));?></span>
                        </div>
                        <h3 class="title"><a href="<?php echo get_permalink() ;?>"><?php echo get_the_title() ;?></a></h3>
                        <span class="local"><?php echo $local;?></span>    
                    </div>
                </div>
            </article>
            <?php
        endwhile; 
        ?>
    </main>
</div>

<?php
get_sidebar(); 
get_footer(); 