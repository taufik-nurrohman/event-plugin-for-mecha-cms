<?php

$events = array(
    glob(POST . DS . 'event' . DS . '*.txt', GLOB_NOSORT),
    glob(POST . DS . 'event' . DS . '*.*', GLOB_NOSORT)
);

Config::set(Mecha::A($config->states->{'plugin_' . md5(File::B(__DIR__))}) + array(
    'defaults.event_title' => Config::get('defaults.event_title', ""),
    'defaults.event_content' => Config::get('defaults.event_content', ""),
    'defaults.event_css' => Config::get('defaults.event_css', ""),
    'defaults.event_js' => Config::get('defaults.event_js', ""),
    'events_path' => $events[0],
    '__events_path' => $events[1],
    'total_events' => count($events[0]),
    '__total_events' => count($events[1]),
    'event_query' => class_exists('Calendar') ? Calendar::$config['query'] : 'calendar'
));

$config = Config::get();
$speak = Config::speak();

if(Plugin::exist('calendar')) {
    require __DIR__ . DS . 'workers' . DS . 'engine' . DS . 'plug' . DS . 'calendar.php';
}

require __DIR__ . DS . 'workers' . DS . 'engine' . DS . 'plug' . DS . 'get.php';

if(strpos($config->url_path . '/', $config->manager->slug . '/event/') === 0) {
    require __DIR__ . DS . 'workers' . DS . 'route.event.php';
}