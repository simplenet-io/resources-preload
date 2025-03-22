<?php
/**
 * Plugin Name: Resources Preload
 * Plugin URI:  https://github.com/simplenet-io/resources-preload/
 * Description: Preloads critical resources (fonts and logo) to improve website performance.
 * Version: 1.2
 * Author: Andrei Chira
 * Author URI: https://simplenet.io/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Define the resources to preload
$preload_resources = array(
  // Logo (above-the-fold image)
  array(
    'url' => 'https://simplenet.io/wp-content/uploads/2025/01/logo-eb.svg', // Replace with the actual logo URL
    'as' => 'image',
    'type' => 'image/svg', // Adapt according to the logo format (png, jpg, svg, etc.)
    'priority' => 'high'
  ),
  // Menu font
  array(
    'url' => 'https://simplenet.io/wp-content/themes/simplenet/assets/fonts/inter/InterVariable.woff2',
    'as' => 'font',
    'type' => 'font/woff2',
    'crossorigin' => true,
    'priority' => 'high'
  ),
  // Heading font
  array(
    'url' => 'https://simplenet.io/wp-content/uploads/fonts/SpaceGroteskwght.woff2', // Replace with the actual URL
    'as' => 'font',
    'type' => 'font/woff2',
    'crossorigin' => true,
    'priority' => 'high'
  )
);

/**
 * Add resource preloading to the header
 */
function add_resources_preload() {
  global $preload_resources;
  
  foreach ($preload_resources as $resource) {
    $output = '<link rel="preload" href="' . esc_url($resource['url']) . '" as="' . esc_attr($resource['as']) . '"';
    
    if (isset($resource['type'])) {
      $output .= ' type="' . esc_attr($resource['type']) . '"';
    }
    
    if (isset($resource['crossorigin']) && $resource['crossorigin']) {
      $output .= ' crossorigin';
    }
    
    if (isset($resource['priority']) && $resource['priority'] === 'high') {
      $output .= ' fetchpriority="high"';
    }
    
    $output .= '>';
    echo $output;
  }
}

/**
 * Use an earlier hook to ensure preloads are among the first things in <head>
 * Priority 1 ensures this runs before most other head elements
 */
add_action('wp_head', 'add_resources_preload', 1);

/**
 * Optionally: Add script to adjust loading order via JavaScript
 */
function add_resource_priority_script() {
  ?>
  <script>
  // This ensures the browser knows these resources are critically important
  document.addEventListener('DOMContentLoaded', function() {
    // You can add additional logic here if needed to further prioritize resources
  });
  </script>
  <?php
}
add_action('wp_head', 'add_resource_priority_script', 2);
