<?php
$composer_plugins = glob(WP_PLUGIN_DIR . '/composer/*');
foreach ($composer_plugins as $plugin) {
    $plugin_basename = basename($plugin);
    if (file_exists($plugin . '/' . $plugin_basename . '.php')) {
        include_once($plugin . '/' . $plugin_basename . '.php');
    }
}
