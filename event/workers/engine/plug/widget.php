<?php

function do_widget_event_archive($url) {
    global $config;
    return $config->url . '/' . $config->event->slug . '/time:' . File::B($url);
}

function do_widget_event_tag($url) {
    global $config;
    if($tag = Get::eventTag('slug:' . File::B($url))) {
        return $config->url . '/' . $config->event->slug . '/kind:' . $tag->id;
    }
    return $url;
}

Filter::add('tag:url', 'do_widget_event_tag');

// Event archive(s)
Widget::plug('eventArchive', function($type = 'HIERARCHY', $sort = 'DESC') {
    $s = Config::get('event_query', "");
    if($s && strpos($s, 'time:') === 0) Config::set('archive_query', substr($s, 5));
    Filter::add('archive:url', 'do_widget_event_archive');
    $output = Widget::archive($type, $sort, POST . DS . 'event');
    Filter::remove('archive:url', 'do_widget_event_archive');
    return $output;
});

// Event tag(s)
Widget::plug('eventTag', function($type = 'LIST', $order = 'ASC', $sorter = 'name', $max_level = 6) {
    $s = Config::get('event_query', "");
    if($s && strpos($s, 'kind:') === 0) {
        if($s = Get::eventTag('id:' . substr($s, 5))) Config::set('tag_query', $s->slug);
    }
    return Widget::tag($type, $order, $sorter, $max_level, POST . DS . 'event');
});

// Recent event(s)
Widget::plug('recentEvent', function($total = 7, $filter = "") {
    return Widget::recentPost($total, $filter, POST . DS . 'event');
});

// Rendom event(s)
Widget::plug('randomEvent', function($total = 7, $filter = "") {
    return Widget::randomPost($total, $filter, POST . DS . 'event');
});

// Related event(s)
Widget::plug('relatedEvent', function($total = 7, $shake = true) {
    return Widget::relatedPost($total, $shake, POST . DS . 'event');
});