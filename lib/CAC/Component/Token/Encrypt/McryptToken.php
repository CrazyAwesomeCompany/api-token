<?php

namespace CAC\Component\Token\Encrypt;

class McryptToken implements EncryptInterface
{
    public function __construct()
    {
        if (!extension_loaded('mcrypt')) {
            throw new EncryptException('mcrypt extension not installed');
        }
    }

    /**
     * (non-PHPdoc)
     * @see \CAC\Component\Token\Encrypt\EncryptInterface::encrypt()
     */
    public function encrypt($secretKey, $userKey)
    {
        $userKey = json_encode($userKey);

        return mcrypt_encrypt(\MCRYPT_RIJNDAEL_256, $secretKey, $userKey, \MCRYPT_MODE_ECB, $this->getIv());
    }

    /**
     * (non-PHPdoc)
     * @see \CAC\Component\Token\Encrypt\EncryptInterface::decrypt()
     */
    public function decrypt($secretKey, $token)
    {
        $cryptText = mcrypt_decrypt(\MCRYPT_RIJNDAEL_256, $secretKey, $token, MCRYPT_MODE_ECB, $this->getIv());
        #remove \0 if any
        $userKey = json_decode(rtrim($cryptText, "\0"), true);

        if (null === $userKey) {
            return false;
        }

        return $userKey;
    }

    /**
     * Generate an IV
     *
     * @return string
     */
    private function getIv()
    {
        $ivSize = mcrypt_get_iv_size(\MCRYPT_RIJNDAEL_256, \MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, \MCRYPT_RAND);
        return $iv;
    }
}
