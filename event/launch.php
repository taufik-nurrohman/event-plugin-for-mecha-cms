<?php

// Constant ...
define('EVENT', POST . DS . 'event');

// Set some default configuration value(s)
$c_event = $config->states->{'plugin_' . md5(File::B(__DIR__))};
$s = __DIR__ . DS . 'workers' . DS . 'engine' . DS . 'plug' . DS;
Config::set(array(
    'index_event' => Mecha::A($c_event),
    'defaults.event_title' => Config::get('defaults.event_title', ""),
    'defaults.event_content' => Config::get('defaults.event_content', ""),
    'defaults.event_css' => Config::get('defaults.event_css', ""),
    'defaults.event_js' => Config::get('defaults.event_js', "")
));

// Add event manager menu
Config::merge('manager_menu', array(
    $speak->event => array(
        'icon' => 'calendar',
        'url' => $config->manager->slug . '/event',
        'stack' => 9.021
    )
));

// refresh ...
$config = Config::get();
$speak = Config::speak();

// Loading event method(s) ...
require $s . 'filter.php';
require $s . 'get.php';

// Loading event widget(s) ...
require $s . 'widget.php';

// Loading event calendar widget ...
Weapon::add('plugins_after', function() use($config, $speak, $s) {
    $q = Plugin::exist('calendar') && class_exists('Calendar') ? Calendar::$config['query'] : "";
    if($q) require $s . DS . 'calendar.php';
});