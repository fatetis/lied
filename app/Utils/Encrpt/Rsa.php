<?php

namespace App\Utils\Encrypt;

/**
 * Created by PhpStorm.
 * User: xie
 * Date: 2016/11/6
 * Time: 15:53
 */
class Rsa
{

    static function sign($beSignMsg, $pfxPath, $pfxPwd)
    {

        $certs = array();
        openssl_pkcs12_read(file_get_contents($pfxPath), $certs, $pfxPwd);
        if (!$certs) return;

        $signature = '';
        openssl_sign($beSignMsg, $signature, $certs['pkey'], "SHA1");

        return base64_encode($signature);
    }

    static function verify($signMsg, $publicKey, $data)
    {

        $key = openssl_get_publickey($publicKey);
        $sign = base64_decode($signMsg);

        $result = (bool)openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1);

        openssl_free_key($key);

        return $result;
    }

    static function encrypt($publicKey, $data)
    {

        $key = openssl_get_publickey($publicKey);

        $original_arr = str_split($data, 117);
        foreach ($original_arr as $o) {
            $sub_enc = null;
            openssl_public_encrypt($o, $sub_enc, $key);
            $original_enc_arr[] = $sub_enc;
        }

        openssl_free_key($key);

        $original_enc_str = base64_encode(implode('', $original_enc_arr));

        return $original_enc_str;
    }

    static function decrypt($data, $pfxPath, $pfxPwd)
    {

        $certs = array();
        openssl_pkcs12_read(file_get_contents($pfxPath), $certs, $pfxPwd);
        if (!$certs) return;

        $decrypt = '';
        openssl_private_decrypt(base64_decode($data), $decrypt, $certs['pkey']);

        return base64_decode($decrypt);
    }

    static function verify2($signMsg, $publicKeyPath, $data)
    {

        $verifyKey4Server = file_get_contents($publicKeyPath);
        $pem = chunk_split(base64_encode($verifyKey4Server), 64, "\n");
        $pem = "-----BEGIN CERTIFICATE-----\n" . $pem . "-----END CERTIFICATE-----\n";
        echo $pem . ']----------<br>';
        $verifyKey = openssl_pkey_get_public($pem);
        $public_key = openssl_get_publickey($verifyKey);
        echo $public_key . ']---------<br>';

        $sign = base64_decode($signMsg);
        $result = (bool)openssl_verify($data, $sign, $public_key, OPENSSL_ALGO_SHA1);
        openssl_free_key($public_key);

        return $result;
    }
}

//$data='i want to xxx you:[0200 190011 111 2016110657248621 06635595 0.1 156]';
//$signMsg=Rsa::sign($data,"d://16036814.pfx","123456");
//$publicKey=
//'-----BEGIN PUBLIC KEY-----
//MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCceqFT+mvdC0e1HwmIeDoAj3Z9
//7fEhIP7QdHf6JzIUx5xZKfviNfxGwPeFdrDvUmwZ78zk2SnsVITxz0a9RxAmsR5E
//ZAdFMrsnjB6tlv4r8Hq8Y3sVmbxvNcb4FiyoPLdmGt6llSSv/QZSauYf4PZg23bL
//d2Hrrsaa+ePIXObIswIDAQAB
//-----END PUBLIC KEY-----';
//echo 'verify:'.Rsa::verify($signMsg,$publicKey,$data);
//echo 'verify:'.Rsa::verify($signMsg,$publicKey,$data);

//$data='signString:[0200 190011 111 2016110657248621 06635595 0.1 156]';
//echo 'sign:'.Rsa::sign($data,Config::merchantPrivateKeyPath,Config::merchantPrivateKeyPwd).'<br>';

//$data='i want to xxx you:[0200 190011 111 2016110657248621 06635595 0.1 156]';
//$signMsg='RxTEqF03jhR0Oa0SErHyuIUmHHZej5irsgj+dPzw/X8NPUoAGJvvP0pri0tWF1eJkWJKTbcHsNdj7wn0CLNwlqARjl1Y5JjHEhGrOI9NW2bbu288draHFvxQclhQYma1N8XSlPqVXAatKp0Rep1/ubswTvHGoCoVMepigibscRs=';
//echo 'verify:'.Rsa::verify($signMsg,Config::merchantPublicKey,$data);

//$data='i want to kill you:[0200 190011 111 2016110657248621 06635595 0.1 156]';
//echo 'encrypt:'.Rsa::encrypt(Config::merchantPublicKey,$data).'<br>';

//$enc='GjQ6uSZlTIAQr6sFqg6/iiwThY8hcGKSproF9n37QDeMEFtjUej2+/1NCLrQjjhAUfNLMWqhtAgo6rRGNqKYuGXgL+LYVZ3391+sBHxRpcIGbYJahfGit7EidnKi+Tm36BpnjmRZFI4dPCVkGxy1CjvmzaKqxylKKVcAOCJkTHg=';
//echo 'decrypt:'.Rsa::decrypt($enc,Config::merchantPrivateKeyPath,Config::merchantPrivateKeyPwd);
