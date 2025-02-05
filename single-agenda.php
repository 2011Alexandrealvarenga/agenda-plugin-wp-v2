<?php
/**
 * Template Single para o Post Type "Agenda"
 */

get_header(); // Carrega o cabeçalho do tema
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="posted-on">Publicado em: <?php the_date(); ?></span>
                    </div>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer">
                    <?php edit_post_link('Editar', '<span class="edit-link">', '</span>'); ?>
                </footer>
            </article>
            <?php
        endwhile; // Fim do loop
        ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar(); // Carrega a sidebar do tema (se houver)
get_footer(); // Carrega o rodapé do tema
?>