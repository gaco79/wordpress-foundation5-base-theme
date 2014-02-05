<?php
/**
 * Foundation 5 Base Theme for Wordpress
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
          get_template_part('layouts/archive/item', get_post_format());
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