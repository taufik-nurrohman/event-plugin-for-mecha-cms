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
    return Get::postPath($detector, POST . DS . 'event');
});

// Get list of event detail(s)
Get::plug('eventExtract', function($input) {
    return Get::postExtract($input, 'event:');
});

// Get list of event(s) path
Get::plug('events', function($order = 'DESC', $filter = "", $e = 'txt') {
    return Get::posts($order, $filter, $e, POST . DS . 'event');
});

// Get list of event(s) detail(s)
Get::plug('eventsExtract', function($order = 'DESC', $sorter = 'time', $filter = "", $e = 'txt') {
    return Get::postsExtract($order, $sorter, $filter, $e, 'event:', POST . DS . 'event');
});

// Get minimum data of an event
Get::plug('eventAnchor', function($path) {
    return Get::postAnchor($path, POST . DS . 'event', '/' . Config::get('event.slug') . '/', 'event:');
});

// Get event header(s) only
Get::plug('eventHeader', function($path) {
    return Get::postHeader($path, POST . DS . 'event', '/' . Config::get('event.slug') . '/', 'event:');
});

// Extract event file into list of event date
Get::plug('event', function($reference, $excludes = array()) {
    return Get::post($reference, $excludes, POST . DS . 'event', '/' . Config::get('event.slug') . '/', 'event:');
});