<?php

namespace CAC\Component\Token;

use CAC\Component\Token\Encrypt\McryptToken;

class TokenGeneratorTest extends \PHPUnit_Framework_TestCase
{
    private $tokenGenerator;

    protected function setUp() {
        $secretKey = 'testing';
        $tokenEncrypter = new McryptToken();
        $this->tokenGenerator = new TokenGenerator($tokenEncrypter, $secretKey);
    }

    public function testValidToken()
    {
        $userKey = 234567;
        $token = $this->tokenGenerator->createToken($userKey);
        $key = $this->tokenGenerator->validateToken($token);

        $this->assertEquals($userKey, $key);
    }

    public function testInvalidTokenSecretKeyChange()
    {
        $userKey = 'fooKey';
        $token = $this->tokenGenerator->createToken($userKey);
        $this->tokenGenerator->setSecretKey('testChange');
        $key = $this->tokenGenerator->validateToken($token);

        $this->assertFalse($key);
    }
}
