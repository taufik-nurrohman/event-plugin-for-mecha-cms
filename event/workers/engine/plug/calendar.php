<?php

// Adding event(s) data to the event calendar ...
Calendar::hook('event', function($lot, $year, $month, $id) use($config, $speak) {
    $c = $config->index_event;
    $the_year = Calendar::year($id, $year);
    $the_month = Calendar::month($id, $month);
    // Load data if the calendar time is equal to current time
    if($the_year === $year && $the_month === $month) {
        $month_str = $month < 10 ? '0' . $month : (string) $month;
        if($files = Get::events(null, 'time:' . $year . '-' . $month_str)) {
            // link to event archive page
            $lot[$year . '/' . $month] = array(
                'url' => $config->url . '/' . $c->slug . '/time:' . $year . '-' . $month_str,
                'description' => $c->title
            );
            $lot_o = array();
            foreach($files as $file) {
                $post = Get::eventAnchor($file);
                list($time, $kind, $slug) = explode('_', File::N($file), 3);
                $s = explode('-', $time);
                // link to event page by default
                $lot_o[$year . '/' . $month . '/' . (int) $s[2]][] = array(
                    'url' => $post->url,
                    'description' => $post->title,
                    'kind' => (array) $post->kind,
                    '_' => $s[2]
                );
            }
            foreach($lot_o as $k => $v) {
                // more than 1 event in a day, link to event archive page
                if(count($v) > 1) {
                    $s = array();
                    foreach($v as $vv) {
                        $s[] = $vv['description'];
                    }
                    $lot[$k]['url'] = $lot[$year . '/' . $month]['url'] . '-' . $v[0]['_'];
                    $lot[$k]['title'] = '%d+'; // add a plus sign
                    $lot[$k]['description'] = implode(', ', $s);
                // else, link to event page
                } else {
                    $lot[$k] = $v[0];
                }
            }
            unset($lot_o, $files);
        }
    }
    // Replace default calendar navigation URL with event archive page URL ...
    $y_p = $lot['prev']['year'];
    $m_p = $lot['prev']['month'];
    $y_n = $lot['next']['year'];
    $m_n = $lot['next']['month'];
    if($m_p < 10) $m_p = '0' . $m_p;
    if($m_n < 10) $m_n = '0' . $m_n;
    $lot['prev']['url'] = $config->url . '/' . $c->slug . '/time:' . $y_p . '-' . $m_p;
    $lot['next']['url'] = $config->url . '/' . $c->slug . '/time:' . $y_n . '-' . $m_n;
    return $lot;
});

// Hijack HTTP query of calendar based on `$config->event_query` value ...
Weapon::add('shield_lot_before', function() use($q) {
    $filter = Config::get('event_query', 'time:' . date('Y-m'));
    if(strpos($filter, 'time:') === 0) {
        $s = explode('-', substr($filter, 5) . '-' . date('m'));
        $_GET[$q]['event']['year'] = (int) $s[0];
        $_GET[$q]['event']['month'] = (int) $s[1];
    }
});