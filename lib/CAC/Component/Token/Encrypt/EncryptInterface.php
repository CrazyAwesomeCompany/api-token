<?php

namespace CAC\Component\Token\Encrypt;

interface EncryptInterface
{
    /**
     * Encrypt the keys to use in token
     *
     * @param string $secretKey
     * @param string $userKey
     */
    public function encrypt($secretKey, $userKey);

    /**
     * Decrypt the token
     *
     * @param string $secretKey
     * @param string $token
     */
    public function decrypt($secretKey, $token);
}
