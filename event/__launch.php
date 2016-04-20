<?php

// Add default event footer link(s)
Weapon::add('event_footer', function($event) use($config, $speak) {
    $status = Mecha::alter(File::E($event->path), array(
        'draft' => Jot::span('info', Jot::icon('clock-o') . ' ' . $speak->draft) . ' &middot; ',
        'archive' => Jot::span('info', Jot::icon('history') . ' ' . $speak->archive) . ' &middot; '
    ), "");
    echo $status . Cell::a($config->manager->slug . '/event/repair/id:' . $event->id, $speak->edit) . ' / ' . Cell::a($config->manager->slug . '/event/kill/id:' . $event->id, $speak->delete);
}, 20);

if(strpos($config->url_path . '/', $config->manager->slug . '/event/') === 0) {
    require __DIR__ . DS . 'workers' . DS . 'route.event.php';
}