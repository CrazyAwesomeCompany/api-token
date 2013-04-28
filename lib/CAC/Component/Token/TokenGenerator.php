<?php

namespace CAC\Component\Token;

use CAC\Component\Token\Encrypt\EncryptInterface;

class TokenGenerator
{
    /**
     * @var EncryptInterface
     */
    private $encrypter;

    /**
     * @var string
     */
    private $secretKey;

    public function __construct(EncryptInterface $encrypter, $secretKey)
    {
        $this->encrypter = $encrypter;
        $this->secretKey = $secretKey;
    }

    /**
     * Create a Token based on the key given
     *
     * @param string|array $userKey
     *
     * @return string
     */
    public function createToken($userKey)
    {
        $tokenData = array('key' => $userKey, 'time' => time());
        $token = $this->encrypter->encrypt($this->secretKey, $tokenData);

        return base64_encode($token);
    }

    /**
     * Validate the given Token and return the user key
     *
     * @param sting $token
     *
     * @return boolean|string|array
     */
    public function validateToken($token)
    {
        $token = base64_decode($token);
        $tokenData = $this->encrypter->decrypt($this->secretKey, $token);

        if (empty($tokenData['key'])) {
            return false;
        }

        return $tokenData['key'];
    }

    /**
     * Set the secret key
     *
     * @param string $key
     */
    public function setSecretKey($key)
    {
        $this->secretKey = $key;
    }
}
