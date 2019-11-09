# PKCS7-PHP

[![Build Status](https://github.com/konomae/pkcs7-php/workflows/PHP%20Composer/badge.svg)](https://github.com/konomae/pkcs7-php/actions)

Degenerate PKCS7 certificate only form.


## Installation

```bash
composer require konomae/pkcs7-php
```


## Example

```php
<?php
use Konomae\PKCS7\Degenerate;

// DER encoded X.509 certificate
$x509 = file_get_contents('/path/to/x509certificate.der');

$p7 = new Degenerate($x509);

// Same result of the command:
// openssl crl2pkcs7 -nocrl -certfile client.crt -outform PEM -out client.p7b.pem
$p7->toPEM();
```
