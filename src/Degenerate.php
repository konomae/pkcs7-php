<?php

namespace Konomae\PKCS7;

use ASN1\DERData;
use ASN1\Type\Constructed\Sequence;
use ASN1\Type\Constructed\Set;
use ASN1\Type\Primitive\Integer;
use ASN1\Type\Primitive\ObjectIdentifier;
use ASN1\Type\Tagged\ExplicitlyTaggedType;
use ASN1\Type\Tagged\ImplicitlyTaggedType;

/**
 * Degenerate certificates-only PKCS7.
 *
 * `openssl crl2pkcs7 -nocrl -certfile client.crt -outform PEM -out client.p7b.pem`
 *
 * To check:
 * `openssl asn1parse -in client.p7b.der -inform PEM -i`
 *
 * @package App\Scep\Pkcs7
 */
class Degenerate
{
    // pkcs7-signedData
    const OID_SIGNED_DATA = '1.2.840.113549.1.7.2';
    // pkcs7-data
    const OID_DATA = '1.2.840.113549.1.7.1';

    /**
     * @var string[]
     */
    private $x509certificates;

    /**
     * Degenerate constructor.
     * @param string[] ...$x509certificates DER encoded X.509 certificates
     */
    public function __construct(string ...$x509certificates)
    {
        $this->x509certificates = $x509certificates;
    }

    /**
     * @return Sequence
     */
    public function toASN1(): Sequence
    {
        return new Sequence(
            new ObjectIdentifier(self::OID_SIGNED_DATA),
            new ExplicitlyTaggedType(0, new Sequence(
                new Integer(1),
                new Set(),
                new Sequence(new ObjectIdentifier(self::OID_DATA)),
                new ImplicitlyTaggedType(
                    0,
                    new Sequence(
                        ...array_map(function ($cert) {
                            return new DERData($cert);
                        }, $this->x509certificates)
                    )
                ),
                new ImplicitlyTaggedType(1, new Sequence()),
                new Set()
            ))
        );
    }

    /**
     * @return string
     */
    public function toDER(): string
    {
        return $this->toASN1()->toDER();
    }

    /**
     * @return string
     */
    public function toPEM(): string
    {
        $encoded = chunk_split(base64_encode($this->toDER()), 64, "\n");

        return "-----BEGIN PKCS7-----\n$encoded-----END PKCS7-----\n";
    }
}
