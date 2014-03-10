<?php

/**
 * Responsive Images Shortcodes
 * 
 * Uses Foundation Interchange
 * @see http://foundation.zurb.com/docs/components/interchange.html
 */
if (!function_exists('interchange_shortcode')) :

  function interchange_shortcode($atts) {
    extract(shortcode_atts(array(
        'id' => 1,
        'class' => ''
                    ), $atts));

    $imageSizes = wp_get_attachment_metadata($atts['id']);

    //Output our image sizes using interchange for images format
    foreach ($imageSizes['sizes'] as $size => $info) {
      $attachment_info = wp_get_attachment_image_src($id, $size);

      $dataInterchange .= '[';
      $dataInterchange .= $attachment_info[0] . ', ';
      $dataInterchange .= '(' . $size . ')';
      $dataInterchange .= '],';

      //edge case where original image is 1600px wide, so xlarge size not generated
      if ($size == 'xlarge') {
        $xLargeIncluded = true;
      }
    }

    //Full size image, only included when xlarge size not generated
    if (!$xLargeIncluded) {
      $upload_dir = wp_upload_dir();
      $dataInterchange .= '[' . $upload_dir['baseurl'] . '/' . $imageSizes['file'] . ', (xlarge)]';
    }

    //Build the interchange <img /> tag
    $html = sprintf('<img alt="%2$s" data-interchange="%1$s" width="%4$d" height="%5$d" class="%6$s" /><noscript><img src="%3$s"></noscript>', $dataInterchange, get_the_title($atts['id']), $imageSizes['file'], $imageSizes['width'], $imageSizes['height'], $atts['class']);

    return $html;
  }

endif;
add_shortcode('responsiveimage', 'interchange_shortcode');

/*
 * Manipulate the <img /> tag inserted by the html editor
 * Should output images compatible with foundation interchange
 */
if (!function_exists('gc_get_image_tag')) :

  function gc_get_image_tag($html, $id, $title) {
    $imageSizes = wp_get_attachment_metadata($id);
    $placeholder = $imageSizes['file'];

    //keep img classes as set by wordpress
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $tags = $doc->getElementsByTagName('img');
    foreach ($tags as $tag) {
      $class = $tag->getAttribute('class');
    }

    //responsive only if this is full size image
    if (strstr($html, 'size-full')) {
      return "[responsiveimage id=\"$id\" placeholder=\"$placeholder\" class=\"$class\"]";
    } else {
      return $html;
    }
  }

endif;
add_filter('get_image_tag', 'gc_get_image_tag', 10, 3);

/**
 * Javascript for the TinyMCE plugin
 */
function gc_add_responsive_image_plugin_js($plugin_array) {
  if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
    $plugin_array['responsiveImagePlugin'] = get_bloginfo('template_url') . '/js/responsiveImagePlugin.min.js';
  }

  return $plugin_array;
}

add_filter('mce_external_plugins', 'gc_add_responsive_image_plugin_js');
