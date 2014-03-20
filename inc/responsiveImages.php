<?php

/**
 * Responsive Images Shortcodes
 * 
 * Uses Foundation Interchange
 * @see http://foundation.zurb.com/docs/components/interchange.html
 */
if (!function_exists('wf5btp_interchange_shortcode')) :

    function wf5btp_interchange_shortcode($atts) {
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

            //original image is smaller than small
            if ($size == 'small') {
                $smallIncluded = true;
            }

            //edge case where original image is exactly 1600px wide, so xlarge size not generated
            if ($size == 'xlarge') {
                $xLargeIncluded = true;
            }
        }

        $upload_dir = wp_upload_dir();
        
        //images smaller than the small size will not generate any sizes other than xlarge
        //make sure the image is made available to smaller devices
        if (!$smallIncluded) {
            $dataInterchange .= '[' . $upload_dir['baseurl'] . '/' . $imageSizes['file'] . ', (small)]';
        }

        //Full size image, only included when xlarge size not generated
        if (!$xLargeIncluded) {
            $dataInterchange .= '[' . $upload_dir['baseurl'] . '/' . $imageSizes['file'] . ', (xlarge)]';
        }

        //Build the interchange <img /> tag
        $html = sprintf('<img alt="%2$s" data-interchange="%1$s" width="%4$d" height="%5$d" class="%6$s" /><noscript><img src="%3$s"></noscript>', $dataInterchange, get_the_title($atts['id']), $imageSizes['file'], $imageSizes['width'], $imageSizes['height'], $atts['class']);

        return $html;
    }

endif;
add_shortcode('responsiveimage', 'wf5btp_interchange_shortcode');

/*
 * Manipulate the <img /> tag inserted by the html editor
 * Should output images compatible with foundation interchange
 */
if (!function_exists('wf5bt_get_image_tag')) :

    function wf5bt_get_image_tag($html, $id, $title) {
        $imageSizes = wp_get_attachment_metadata($id);
        $placeholder = $imageSizes['file'];

        //keep img classes as set by wordpress
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $tags = $doc->getElementsByTagName('img');
        foreach ($tags as $tag) {
            $class = $tag->getAttribute('class');
            $width = $tag->getAttribute('width');
        }

        // Responsive only if this is full size image 
        // && larger than small image size (or no point)
        if (strstr($html, 'size-full') && $width>640) {
            return "[responsiveimage id=\"$id\" placeholder=\"$placeholder\" class=\"$class\"]";
        } else {
            return $html;
        }
    }

endif;
add_filter('get_image_tag', 'wf5bt_get_image_tag', 10, 3);
