<?php
/**
 * Foundation 5 Base Theme for Wordpress
 * 
 * In the interests of keeping this theme as simple as possible, I have only included an index.php file.
 * Wordpress supports many template files for different layouts such as categories, tags, single posts, 
 * single pages, etc, etc.
 * 
 * For further information see
 *   http://codex.wordpress.org/Stepping_Into_Templates
 *   https://yoast.com/wordpress-theme-anatomy/
 * 
 * @package WordpressFoundation5BaseTheme
 */
get_header();
?>

<div id="content">
  <div class="row">

    <?php if (have_posts()) : ?>

      <?php /* Start the Loop */ ?>
      <?php while (have_posts()) : the_post(); ?>

        <div class="small-12">
          <?php
          get_template_part('template-parts/item', get_post_format());
          ?>
        </div>

      <?php endwhile; ?>

    <?php else : ?>

      <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
          <h1 class="entry-title"><?php _e('Nothing Found', 'toolbox'); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
          <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'toolbox'); ?></p>
          <?php get_search_form(); ?>
        </div><!-- .entry-content -->
      </article><!-- #post-0 -->

    <?php endif; ?>

  </div>
</div>
<?php
get_footer();
?>