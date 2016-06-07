<?php

// Get event tag(s)
Get::plug('eventTags', function($order = 'ASC', $sorter = 'name') {
    return Get::tags($order, $sorter, 'event');
});

// Return specific event tag item filtered by its available data
Get::plug('eventTag', function($filter, $output = null, $fallback = false) {
    return Get::tag($filter, $output, $fallback, 'event');
});

// Get event path
Get::plug('eventPath', function($detector) {
    return Get::postPath($detector, EVENT);
});

// Get list of event detail(s)
Get::plug('eventExtract', function($input) {
    return Get::postExtract($input, 'event:');
});

// Get list of event(s) path
Get::plug('events', function($order = 'DESC', $filter = "", $e = 'txt') {
    return Get::posts($order, $filter, $e, EVENT);
});

// Get list of event(s) detail(s)
Get::plug('eventsExtract', function($order = 'DESC', $sorter = 'time', $filter = "", $e = 'txt') {
    return Get::postsExtract($order, $sorter, $filter, $e, EVENT, 'event:');
});

// Get minimum data of an event
Get::plug('eventAnchor', function($path) use($c_event) {
    $c = Config::get('index.slug');
    Config::set('index.slug', $c_event->event->slug);
    $post = Get::postAnchor($path, EVENT, 'event:');
    Config::set('index.slug', $c);
    return $post;
});

// Get event header(s) only
Get::plug('eventHeader', function($path) use($c_event) {
    $c = Config::get('index.slug');
    Config::set('index.slug', $c_event->event->slug);
    $post = Get::postHeader($path, EVENT, 'event:');
    Config::set('index.slug', $c);
    return $post;
});

// Extract event file into list of event data
Get::plug('event', function($reference, $excludes = array()) use($c_event) {
    $c = Config::get('index.slug');
    Config::set('index.slug', $c_event->event->slug);
    $post = Get::post($reference, $excludes, EVENT, 'event:');
    Config::set('index.slug', $c);
    return $post;
});