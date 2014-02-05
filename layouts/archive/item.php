<?php
/**
 * 
 */
?>
<!-- content -->
<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
  <header class="entry-header">
    <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'toolbox'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

    <?php if ('post' == get_post_type()) : ?>
      <div class="entry-meta">
        <?php //toolbox_posted_on(); ?>
      </div><!-- .entry-meta -->
    <?php endif; ?>
  </header><!-- .entry-header -->

  <?php if (is_search()) : // Only display Excerpts for Search ?>
    <div class="entry-summary">
      <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->
  <?php else : ?>
    <div class="entry-content">
      <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'toolbox')); ?>
      <?php wp_link_pages(array('before' => '<div class="page-link">' . __('Pages:', 'toolbox'), 'after' => '</div>')); ?>
    </div><!-- .entry-content -->
  <?php endif; ?>

  <div style="clear:both"></div>

</article><!-- #post-<?php the_ID(); ?> -->
