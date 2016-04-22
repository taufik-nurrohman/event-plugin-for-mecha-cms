<?php


// Exclude these fields ...
$excludes = array('content');


/**
 * Index Event Page
 * ----------------
 *
 * [1]. event
 * [2]. event/1
 * [3]. event/kind:4
 * [4]. event/kind:4/1
 *
 */

/**
 * Event Page
 * ----------
 *
 * [1]. event/event-slug
 *
 */

Route::accept(array($config->event->slug, $config->event->slug . '/(:any)', $config->event->slug . '/(:any)/(:num)'), function($filter = "", $offset = 1) use($config, $excludes) {
    if(is_numeric($filter)) {
        $offset = $filter;
        $filter = "";
    }
    // Event page ...
    if($filter && strpos($filter, ':') === false) {
        // Force disable comment(s) ...
        Config::set('comments.allow', false);
        if( ! $event = Get::event($filter)) {
            Shield::abort('404-event');
        }
        if($event->state === 'drafted') {
            Shield::abort('404-event');
        }
        // Collecting event slug ...
        if($events = Get::events('DESC', "", File::E($event->path))) {
            $events = Mecha::walk($events, function($path) {
                $parts = explode('_', File::N($path), 3);
                return $parts[2];
            });
        }
        Filter::add('pager:url', function($url) {
            return Filter::apply('event:url', $url);
        });
        Config::set(array(
            'page_title' => $event->title . $config->title_separator . $config->title,
            'page_type' => 'event',
            'event' => $event,
            'article' => $event, // alias
            'pagination' => Navigator::extract($events, $filter, 1, $config->event->slug),
            'is.posts' => false,
            'is.post' => true
        ));
        Weapon::add('shell_after', function() use($event) {
            if(isset($event->css) && trim($event->css) !== "") echo O_BEGIN . $event->css . O_END;
        }, 11);
        Weapon::add('sword_after', function() use($event) {
            if(isset($event->js) && trim($event->js) !== "") echo O_BEGIN . $event->js . O_END;
        }, 11);
        $s = file_exists(SHIELD . DS . $config->shield . DS . 'event.php') ? 'event' : 'article';
        Shield::attach($s . '-' . $filter);
    }
    // Index event page ...
    $_ = explode(':', $filter, 2);
    $p = Mecha::alter($_[0], array(
        'time' => 'archive',
        'kind' => 'tag',
        'slug' => 'search',
        'keyword' => 'search'
    ), 'index');
    $s = Get::events(null, $filter);
    if($events = Mecha::eat($s)->chunk($offset, $config->event->per_page)->vomit()) {
        $events = Mecha::walk($events, function($path) use($excludes) {
            return Get::event($path, $excludes);
        });
    } else {
        if($offset !== 1) {
            Shield::abort('404-' . $p . '-event');
        } else {
            $events = false;
        }
    }
    Filter::add('pager:url', function($url) use($p) {
        return Filter::apply($p . '-event:url', $url);
    });
    Config::set(array(
        'page_title' => $config->event->title . $config->title_separator . $config->title,
        'page_type' => $p . '-event',
        'event_query' => $filter,
        'offset' => $offset,
        'events' => $events,
        'articles' => $events, // alias
        'pagination' => Navigator::extract($s, $offset, $config->event->per_page, $config->event->slug . '/' . $filter),
        'is.posts' => true,
        'is.post' => false
    ));
    $s = file_exists(SHIELD . DS . $config->shield . DS . $p . '-event.php') ? $p . '-event' : 'index';
    Shield::attach($s);
}, 30);