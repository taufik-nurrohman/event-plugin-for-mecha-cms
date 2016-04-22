<?php

// Add default event footer link(s)
Weapon::add('event_footer', function($event) use($config, $speak) {
    $status = Mecha::alter(File::E($event->path), array(
        'draft' => Jot::span('info', Jot::icon('clock-o') . ' ' . $speak->draft) . ' &middot; ',
        'archive' => Jot::span('info', Jot::icon('history') . ' ' . $speak->archive) . ' &middot; '
    ), "");
    echo $status . Cell::a($config->manager->slug . '/event/repair/id:' . $event->id, $speak->edit) . ' / ' . Cell::a($config->manager->slug . '/event/kill/id:' . $event->id, $speak->delete);
}, 20);

// Add event template for AJAX preview
$f = PLUGIN . DS . '__preview' . DS . 'workers' . DS . 'event.php';
if(Plugin::exist('__preview') && ! file_exists($f)) {
    File::open(File::D($f) . DS . 'article.php')->copyTo($f);
}

// Remove event template on plugin eject or destruct
Weapon::add(array(
    'on_plugin_' . md5(File::B(__DIR__)) . '_eject',
    'on_plugin_' . md5(File::B(__DIR__)) . '_destruct'
), function() use($f) {
    File::open($f)->delete();
});

// Loading backend route(s) ...
if(strpos($config->url_path . '/', $config->manager->slug . '/event/') === 0) {
    require __DIR__ . DS . 'workers' . DS . 'route.event.php';
}