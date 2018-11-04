<?php

namespace app\api\controller\v1;

use Blocktrail\CryptoJSAES\CryptoJSAES;
use Defuse\Crypto\Crypto;
use Firebase\JWT\JWT;

class Tests
{
    public function test()
    {
        dump(password_hash('fengF123', PASSWORD_DEFAULT));
    }

    public function test1()
    {
        $str = "id=1&num=11&asd=";
        $passphrase = config('aes.token_salt');
        // 加密
        $encryted = Crypto::encrypt($str,$passphrase,true);
        dump($encryted);
        // 解密
        $decrypted = CryptoJSAES::decrypt($encryted, $passphrase);
        dump($decrypted);
    }
}