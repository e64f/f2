<?php

error_reporting(E_ALL);
ini_set("display_errors", true);

require_once 'func.php';
require_once './vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('./templates');
$twig = new \Twig\Environment($loader, []);


$mysqlParams = array(
    'host'     => 'localhost',
    'username' => 'fuser',
    'password' => '9Xvq8BK~jXt4-Z#',
    'dbname'   => 'filkos_db',
    'charset'  => 'utf8',
    '_debug'   => false,
    '_prefix'  => 'tbl_',
);

$db = go\DB\DB::create($mysqlParams, 'mysql');


$url = $_SERVER['REQUEST_URI'];

if ($url == '/') {
    # Main Page
    $params = array(
        'info' => '',
        'url' => '',
    );
    echo $twig->render('index.html', $params);
} elseif ($url == '/add') {
    # Add Page
    $newLink = getNewLink($_REQUEST['url']);
    $params = array(
        'info' => 'Your link: ' . $newLink,
        'url' => '',
    );
    echo $twig->render('index.html', $params);
} elseif (strlen($url) == 7) {
    # Redirect Page
    $redirectLink = getLink($url);
    if ($redirectLink) {
        $params = array(
            'url' => $redirectLink
        );
        echo $twig->render('redirect.html', $params);
    } else {
        $params = array(

            'info' => 'Bad Request',
            'url' => '',
        );
        echo $twig->render('index.html', $params);
    }
} else {
    # Error Page
    $params = array(
        'info' => 'Error',
        'url' => '',
    );
    echo $twig->render('index.html', $params);
}



