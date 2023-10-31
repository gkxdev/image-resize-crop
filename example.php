<?php
require_once __DIR__ . '/Image.php';

// Yeniden boyutlandır
(new Image('images/sample.jpg'))
    ->resize(800, 600)
    ->save('images/sample-800x600.jpg');

// Yeniden boyutlandır ve ortalı bir şekilde kırp
// 1:1 oranında profil fotoğrafları için kullanılabilir
(new Image('images/sample.jpg'))
    ->resize(500, 500, true)
    ->save('images/sample-500x500.jpg');

// JPEG kalitesini ayarla
$image = new Image('images/sample.jpg');
$image->resize(800, 600);
$image->save('images/sample-800x600-low.jpg', 25);

// Görüntüyü dinamik olarak ekrana bas
(new Image('images/sample.jpg'))
    ->resize(500, 500, true)
    ->display();