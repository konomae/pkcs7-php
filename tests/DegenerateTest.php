<?php

use Konomae\PKCS7\Degenerate;

class DegenerateTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testPEM()
    {
        // openssl req -x509 -newkey rsa:1024 -keyout key.pem -passout pass:secret -out cert.pem -outform pem -days 3650
        // openssl x509 -in cert.pem -out cert.der -outform der
        // openssl crl2pkcs7 -nocrl -certfile cert.pem -outform PEM -out cert.p7b.pem

        $file = file_get_contents(__DIR__ . '/fixtures/cert.der');
        $expected = file_get_contents(__DIR__ . '/fixtures/cert.p7b.pem');

        $d = new Degenerate($file);

        $this->assertEquals($expected, $d->toPEM());
    }
}
