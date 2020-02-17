# PHP ile TC Kimlik Numarası Doğrulama
PHP TC Kimlik Numarası Doğrulama Kütüphanesi

Kurulum

```
composer require umitbilgin/tckimlikdogrula
```

Kullanımı

```php
require_once __DIR__ . "/vendor/autoload.php";

$dogrula = new \TCKimlikDogrula\TCKimlikDogrula;

if($dogrula->check("11111111111","ÜMİT","BİLGİN","2000")) {
    echo "TC Kimlik Numarası Doğrulandı";
} else {
    echo "TC Kimlik Numarası Hatalı";
}

```
