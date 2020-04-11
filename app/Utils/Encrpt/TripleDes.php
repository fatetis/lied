<?php

namespace App\Utils\Encrypt;

/**
 * Created by PhpStorm.
 * User: xie
 * Date: 2016/11/6
 * Time: 14:34
 */
class TripleDes
{

    static function encrypt($key, $input)
    { // 数据加密

        $key = base64_decode($key);

        $size = @mcrypt_get_block_size(MCRYPT_3DES, 'ecb');
        $input = TripleDes::pkcs5_pad($input, $size);
        $key = str_pad($key, 24, '0');
        $td = @mcrypt_module_open(MCRYPT_3DES, '', 'ecb', '');
        $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        @mcrypt_generic_init($td, $key, $iv);
        $data = @mcrypt_generic($td, $input);
        @mcrypt_generic_deinit($td);
        @mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    static function decrypt($key, $encrypted)
    {
        $encrypted = base64_decode($encrypted);
        $key = str_pad($key, 24, '0');
        $td = mcrypt_module_open(MCRYPT_3DES, '', 'ecb', '');
        $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        $ks = mcrypt_enc_get_key_size($td);
        @mcrypt_generic_init($td, $key, $iv);
        $decrypted = mdecrypt_generic($td, $encrypted);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $y = TripleDes::pkcs5_unpad($decrypted);
        return $y;
    }

    static function pkcs5_pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    static function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }

    static function PaddingPKCS7($data)
    {
        $block_size = mcrypt_get_block_size(MCRYPT_3DES, MCRYPT_MODE_EBC);
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char), $padding_char);
        return $data;
    }


}

//$key = 'c60e0db5db5461cb3c5160e6';
//$enc = 'QRcAsGRsXj51ikW3eSxDXdlxuYOWDe9UEfkABPW2LMTsZ8Os/AxCcgUkDtgd0ixTm8LtoBSz53o=';
//echo TripleDes::decrypt($key,$enc).'--------<br>';
//echo TripleDes::encrypt($key,'i want to fuck you:[0200 190011 111 2016110657248621 06635595 0.1 156]').'<br>';