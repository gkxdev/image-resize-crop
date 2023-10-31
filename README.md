# Image Resize Crop

Resim dosyalarını yeniden boyutlandırabilir, kalitesini ayarlayabilir ve profil fotoğraflarında olduğu gibi ortalı bir şekilde kırpma işlemi uygulayabilirsiniz. Uygulanan bu işlemleri, farklı bir isim ve resim uzantısı ile diske yazabilir veya tarayıcıda dinamik olarak çıktı verebilirsiniz. PHP GD extension ile çalışır.

## Kullanımı

```php
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
```

### resize($width, $height, bool $crop = false)

Resim dosyasını yeniden boyutlandırır. Yeniden boyutlandırma işlemi ile birlikte ortalı bir şekilde kırpma işlemi uygulamak istiyorsanız `$crop` parametresini `true` olarak ayarlayınız.

### save($file, int $quality = 90)

Yeniden boyutlandırılan resim dosyasını diske yazmak için kullanılır. JPEG formatında kayıt ediyorsanız `$quality` parametresi ile `0 - 100` arasında bir kalite oranı tanımlayabilirsiniz. Tanımlama yapmazsanız varsayılan değeri 90'dır.

### display(int $quality = 90)

Yeniden boyutlandırılan resim dosyasını diske kayıt etmeden dinamik olarak tarayıcıda ekrana basar.