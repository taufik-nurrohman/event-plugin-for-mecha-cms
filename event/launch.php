<?php

// Cache event(s) path to the configuration
$events = array(
    glob(POST . DS . 'event' . DS . '*.txt', GLOB_NOSORT),
    glob(POST . DS . 'event' . DS . '*.*', GLOB_NOSORT)
);

// Set some default configuration value(s)
Config::set(Mecha::A($config->states->{'plugin_' . md5(File::B(__DIR__))}) + array(
    'defaults.event_title' => Config::get('defaults.event_title', ""),
    'defaults.event_content' => Config::get('defaults.event_content', ""),
    'defaults.event_css' => Config::get('defaults.event_css', ""),
    'defaults.event_js' => Config::get('defaults.event_js', ""),
    'events_path' => $events[0],
    '__events_path' => $events[1],
    'total_events' => count($events[0]),
    '__total_events' => count($events[1])
));

// Add event manager menu
Config::merge('manager_menu', array(
    $speak->event => array(
        'icon' => 'calendar',
        'url' => $config->manager->slug . '/event',
        'stack' => 9.021
    )
));

$config = Config::get();
$speak = Config::speak();

// Loading event method(s) ...
require __DIR__ . DS . 'workers' . DS . 'engine' . DS . 'plug' . DS . 'get.php';

// Loading event widget(s) ...
require __DIR__ . DS . 'workers' . DS . 'engine' . DS . 'plug' . DS . 'widget.php';

// Loading event calendar widget ...
Weapon::add('plugins_after', function() use($config, $speak) {
    $q = Plugin::exist('calendar') && class_exists('Calendar') ? Calendar::$config['query'] : "";
    if($q) require __DIR__ . DS . 'workers' . DS . 'engine' . DS . 'plug' . DS . 'calendar.php';
});