<?php
    //============================ KRIPTO ====================//
    $ciphertext_base64 = $postencript;
    $key = "ExpertuptsiINSTITUT_ASIA";

    $method = "AES-128-CTR";
    $option = 0;
    $iv2 = "1251632135716362";

    $key_size =  strlen($key);

    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

    $ciphertext_dec = base64_decode(base64_decode($ciphertext_base64));


    $dataDecrypt=openssl_decrypt($ciphertext_dec, $method, $key, $option, $iv2);

    $iv_dec = substr($dataDecrypt, 0, $iv_size);
    $ciphertext_decas = substr($dataDecrypt, $iv_size);

    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_decas, MCRYPT_MODE_CBC, $iv_dec);

    ?>