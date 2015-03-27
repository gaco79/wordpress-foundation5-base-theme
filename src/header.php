<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and Top-Bar 'Primary' menu
 * 
 */
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
  <!--<![endif]-->
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <title><?php
      /*
       * Print the <title> tag based on what is being viewed.
       */
      global $page, $paged;

      wp_title('|', true, 'right');

// Add the blog name.
      bloginfo('name');

// Add the blog description for the home/front page.
      $site_description = get_bloginfo('description', 'display');
      if ($site_description && ( is_home() || is_front_page() ))
        echo " | $site_description";

// Add a page number if necessary:
      if ($paged >= 2 || $page >= 2)
        echo ' | ' . sprintf(__('Page %s', 'toolbox'), max($paged, $page));
      ?>
    </title>

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/modernizr.js"></script>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" type="text/css" media="all"
          href="<?php bloginfo('stylesheet_url'); ?>" />
          <?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>

    <div class="contain-to-grid fixed">
      <nav class="top-bar" data-topbar data-options="mobile_show_parent_link: true" role="navigation">
        <ul class="title-area">
          <!-- Title Area -->
          <li class="name">
            <h1>
              <a href="<?php echo home_url('/'); ?>"
                 title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"
                 rel="home">
                <i class="fa fa-camera-retro fa-fw"></i> <?php bloginfo('name'); ?> </a>
            </h1>
          </li>
          <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
          <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span> </a>
          </li>
        </ul>

        <section class="top-bar-section">

          <?php if (is_user_logged_in()) : ?>
            <ul class="right show-for-large-up">
              <li class="has-dropdown"><a href="#"><?php echo get_avatar(get_current_user_id(), '48'); ?></a>
                <ul class="dropdown">
                  <?php if (current_user_can('edit_post')) : ?>
                    <li><?php edit_post_link('Edit ' . get_post_type()); ?></li>
                  <?php endif; ?>

                  <?php if (current_user_can('publish_posts')) : ?> 
                    <li><a href="<?php echo site_url(); ?>/wp-admin/post-new.php">
                        Add New Post
                      </a></li>
                  <?php endif; ?>

                  <li><a href="<?php echo get_edit_user_link(); ?>">
                      My Profile
                    </a></li>
                  <li><a href="<?php echo admin_url(); ?>">
                      Site Admin
                    </a></li>
                  <li><a href="<?php echo wp_logout_url(get_permalink()); ?>">
                      Log Out
                    </a></i>
                </ul></li>
            </ul>
          <?php endif; ?>

          <!-- Wordpress Menu -->
          <?php
          $options = array(
              'theme_location' => 'primary',
              'container' => false,
              'depth' => 2,
              'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
              'walker' => new GC_walker_nav_menu()
          );
          ?>
          <?php wp_nav_menu($options); ?>

          <ul class="right">            
            <li class="divider"></li>
            <li class="has-form">
              <form role="search" method="get" id="searchform"
                    class="searchform" action="<?php echo home_url('/'); ?>"
                    data-abide>
                <div class="row collapse">
                  <div class="small-8 columns">
                    <input type="search" name="s" id="s" placeholder="Find something"
                           required title="Hit enter to search" />
                  </div>
                  <div class="small-4 columns">
                    <input type="submit" value="Search" class="button" />
                  </div>
                </div>
              </form>
            </li>

          </ul>

        </section>
      </nav>
    </div>