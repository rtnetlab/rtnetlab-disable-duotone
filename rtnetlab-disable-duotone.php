<?php
/**
 * Plugin Name:       Rtnetlab Disable Duotone
 * Description:       Disable Duotone feature. Results in a smaller homepage (~7Kb of code removed from the DOM)
 * Version:           1.0.0
 * Requires at least: 6.2
 * Requires PHP:      8.0
 * Author:            Rémi T'JAMPENS
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       rtnetlab-disable-duotone
 */

if (has_action('wp_body_open', 'wp_global_styles_render_svg_filters')) {
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
}

function rtnetlab_disable_duotone_remove_duotone_css_styles(): void
{
    $styles = wp_styles();
    $global_styles = $styles->query('global-styles');

    if (!$global_styles || !isset($global_styles->extra['after'])) {
        return;
    }

    $css = $global_styles->extra['after'];
    if (!$css) {
        return;
    }

    $css = is_array($css) ? implode('; ', $css) : $css;
    $css = preg_replace('/--wp--preset--duotone--.+?\)\s*;/', '', $css);

    $global_styles->extra['after'] = [$css];
}

add_action('wp_enqueue_scripts', 'rtnetlab_disable_duotone_remove_duotone_css_styles');
