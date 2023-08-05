<?php
/**
 * Plugin Name: Plugin Loader
 * Description: Loads plugins from composer subdirectory
 * Version: 0.1
 */

$composer_plugins = glob(dirname(__FILE__) . '/composer/*');
foreach ($composer_plugins as $plugin) {
    $plugin_basename = basename($plugin);
    if (file_exists($plugin . '/' . $plugin_basename . '.php')) {
        include_once($plugin . '/' . $plugin_basename . '.php');
    }
}
