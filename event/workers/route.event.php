<?php

$post = 'event';
$response = 'comment';
$__DIR__ = PLUGIN . DS . 'manager' . DS . 'workers';

// default tag is `untagged`
if( ! isset($_POST['kind'])) {
    $_POST['kind'] = array(0);
}

// Combine date part(s)
if(isset($_POST['date']) && is_array($_POST['date'])) {
    $s = $_POST['date'];
    $_POST['date'] = date('c', strtotime($s[0] . '/' . $s[1] . '/' . $s[2] . ' ' . $s['3-4'] . ':00'));
}

// Repair
if(strpos($config->url_path, '/id:') !== false) {
    Weapon::add('tab_button_before', function($page, $segment) use($config, $speak, $__DIR__) {
        include $__DIR__ . DS . 'unit' . DS . 'tab' . DS . 'button' . DS . 'new.php';
    }, .9);
    Weapon::add('tab_content_1_before', function($page, $segment) use($config, $speak) {
        include __DIR__ . DS . 'unit' . DS . 'form' . DS . 'date[].php';
    }, .9);
}

Weapon::add('tab_content_1_before', function($page, $segment) use($config, $speak, $__DIR__) {
    include $__DIR__ . DS . 'unit' . DS . 'form' . DS . 'post' . DS . 'kind[].php';
}, 6.1);

require $__DIR__ . DS . 'route.post.php';