<?php

/**
 * Support for Foundation Tabs
 * 
 * @see http://foundation.zurb.com/docs/components/tabs.html
 */
if (!function_exists('wfbt_tabs')) :

    function wfbt_tabs($atts, $content = null) {
        extract(shortcode_atts(array(
            'direction' => 'horizontal'
                        ), $atts, 'tabs-atts'));
        
        // render shortcodes contained within the [tabs] shortcode
        // specifically, we want the [tab] shortcodes to have rendered to html
        $content = do_shortcode($content);
        $content = sprintf('<div class="tabs-content %2$s">%1$s</div>', $content, $direction);

        // Work thorugh the content and pull out all <div>'s with class 'content' or 'content active'
        // Get the titles and link IDs from these divs
        $doc = new DOMDocument();
        @$doc->loadHTML($content);
        $divs = $doc->getElementsByTagName('div');
        foreach ($divs as $div) {
            if ($div->getAttribute('class') === 'content' || $div->getAttribute('class') === 'content active') {
                $tab['id'] = $div->getAttribute('id');
                $tab['title'] = $div->getAttribute('data-title');
                $tab['active'] = $div->getAttribute('class') === 'content active' ? true : false;

                $tabs[] = $tab;
            }
        }

        // Generate the tabs <dl>
        $tabTitles = sprintf('<dl class="tabs %1$s" data-tab>', $direction);
        foreach ($tabs as $tab) {
            $tabTitles .= sprintf('<dd%3$s><a href="#%1$s">%2$s</a></dd>', $tab['id'], $tab['title'], $tab['active'] ? ' class="active"' : '');
        }
        $tabTitles .= '</dl>';

        //Add the tabs <dl> to the [tab] content
        $html = $tabTitles . $content;

        return $html;
    }

endif;
add_shortcode('tabs', 'wfbt_tabs');


if (!function_exists('wfbt_tab')) :

    /**
     * A single tab
     */
    function wfbt_tab($atts, $content = null) {
        extract(shortcode_atts(array(
            'title' => 'Untitled Tab. Please set title attribute.',
            'active' => false
                        ), $atts, 'tab-atts'));
        
        //TODO generate link id if specifically set, or regenerate if illegal, eg starts with number
        $id = preg_replace('/[^A-Za-z0-9]/', '', $title);
        
        $html = sprintf('<div class="content%2$s" id="%3$s" data-title="%4$s">%1$s</div>', $content, ($active) ? ' active' : '', $id, htmlspecialchars($title));

        return $html;
    }

endif;
add_shortcode('tab', 'wfbt_tab');
