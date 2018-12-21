/**
 * Created by PhpStorm.
 * User: mishapivo
 * Date: 21.12.2018
 * Time: 22:51
 */

<?php get_header(); ?>
    <main class="wrap">
        <section class="content-area content-thin">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="article-full">
                    <header>
                        <h2><?php the_title(); ?></h2>
                        Автор: <?php the_author(); ?>
                    </header>
                    <?php the_content(); ?>
                </article>
            <?php endwhile; else : ?>
                <article>
                    <p>Извините, записи не были найдены!</p>
                </article>
            <?php endif; ?>
        </section><?php get_sidebar(); ?>
    </main>
<?php get_footer(); ?>