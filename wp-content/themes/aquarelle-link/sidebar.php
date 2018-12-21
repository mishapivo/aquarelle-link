/**
 * Created by PhpStorm.
 * User: mishapivo
 * Date: 21.12.2018
 * Time: 22:50
 */

<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
    <aside id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar' ); ?>
    </aside>
<?php endif; ?>


