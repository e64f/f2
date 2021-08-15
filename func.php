<?php

function getLink($code) {
    global $db;

    $links = $db->query("SELECT code, url FROM tbl_links WHERE code = ?", array( substr($code, 1) ), 'assoc');

    if (count($links) == 1) {
        return $links[0]['url'];
    } else {
        return false;
    }


}

function getNewLink($newLink) {
    global $db;

    // Проверяем есть ли у нас в базе УЖЕ эта ссылка
    $links = $db->query("SELECT code, url FROM tbl_links WHERE url = ?", array($newLink), 'assoc');
    if (count($links) > 0) {
        $url = $_SERVER['HTTP_ORIGIN']."/". $links[0]['code'];
        return "<a href='".$url."' target='_blank'>".$url."</a>";
    }

    $code = getRandomCode();
    // Проверяем есть ли у нас в базе УЖЕ этот код
    $links = $db->query("SELECT code, url FROM tbl_links WHERE code = ?", array($code), 'assoc');
    if (count($links) > 0) {
        // В задании не было описания как поступать в случае генерации уже существующего кода
        // Нужно генерировать занова с не более определенного количества раз (вдруг все вариации заняты)
        // Вобщем оставляю заглушку
        return "ERROR";
    }

    // Сохраняем ссылку в базу
    $db->query("INSERT INTO tbl_links (code, url) VALUES  (?, ?);", array($code, $newLink));


    $url = $_SERVER['HTTP_ORIGIN']."/". $code;


    return "<a href='".$url."' target='_blank'>".$url."</a>";
}

function getRandomCode() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i <= 5; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}
