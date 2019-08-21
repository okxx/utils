<?php
namespace utils\src;

/**
 * Class Rsa
 * @package utils\src
 */
final class Rsa
{
    public static function encode($orignData, $privateKeyFilePath, $isPrivate = true)
    {
        if ($isPrivate) {
            //生成Resource类型的密钥，如果密钥文件内容被破坏，openssl_pkey_get_private函数返回false
            $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyFilePath));
            if (!$privateKey) {
                return false;
            }
        } else {
            //生成Resource类型的公钥，如果公钥文件内容被破坏，openssl_pkey_get_public函数返回false
            $privateKey = openssl_pkey_get_public(file_get_contents($privateKeyFilePath));
            if (!$privateKey) {
                return false;
            }
        }

        $encryptData = '';

        if ($isPrivate) {
            if (openssl_private_encrypt($orignData, $encryptData, $privateKey, OPENSSL_PKCS1_PADDING)) {
                return base64_encode($encryptData);
            } else {
                return false;
            }
        } else {
            if (openssl_public_encrypt($orignData, $encryptData, $privateKey, OPENSSL_PKCS1_PADDING)) {
                return base64_encode($encryptData);
            } else {
                return false;
            }
        }
    }

    public static function sign($orignData, $privateKeyFilePath)
    {
        //生成Resource类型的密钥，如果密钥文件内容被破坏，openssl_pkey_get_private函数返回false
        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyFilePath));
        if (!$privateKey) {
            return false;
        }

        $return = openssl_sign($orignData, $sign, $privateKey, OPENSSL_ALGO_SHA256);
        if ($return) {
            return base64_encode($sign);
        }

        return false;
    }

    public static function verify($orignData, $signature, $publicKeyFilePath)
    {
        //生成Resource类型的公钥，如果公钥文件内容被破坏，openssl_pkey_get_public函数返回false
        $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyFilePath));
        if (!$publicKey) {
            return false;
        }

        $signature = base64_decode($signature);
        $return = openssl_verify($orignData, $signature, $publicKey, "sha256WithRSAEncryption");

        if ($return) {
            return true;
        }

        return false;
    }

    public static function decode($encryptData, $publicKeyFilePath,  $isPublic = true)
    {
        if ($isPublic) {
            //生成Resource类型的公钥，如果公钥文件内容被破坏，openssl_pkey_get_public函数返回false
            $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyFilePath));
            if (!$publicKey) {
                return false;
            }
        } else {
            //生成Resource类型的密钥，如果密钥文件内容被破坏，openssl_pkey_get_private函数返回false
            $publicKey = openssl_pkey_get_private(file_get_contents($publicKeyFilePath));
            if (!$publicKey) {
                return false;
            }
        }

        $decryptData = '';
        $encryptData = base64_decode($encryptData);
        if ($isPublic) {
            if (openssl_public_decrypt($encryptData, $decryptData, $publicKey, OPENSSL_PKCS1_PADDING)) {
                return $decryptData;
            } else {
                return false;
            }
        } else {
            if (openssl_private_decrypt($encryptData, $decryptData, $publicKey, OPENSSL_PKCS1_PADDING)) {
                return $decryptData;
            } else {
                return false;
            }
        }
    }
}
