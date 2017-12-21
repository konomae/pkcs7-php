# PKCS7-PHP

[![Build Status](https://travis-ci.org/konomae/pkcs7-php.svg?branch=master)](https://travis-ci.org/konomae/pkcs7-php)

Degenerate PKCS7 certificate only form.


```php
<?php
use Konomae\PKCS7\Degenerate;

// DER encoded X.509 certificate
$x509 = file_get_contents('/path/to/x509certificate.der');

$p7 = new Degenerate($x509);
$p7->toPEM();
```
