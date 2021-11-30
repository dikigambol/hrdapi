<?php
    //============================ KRIPTO ====================//

    $plaintext = $dataready;
    $key = "ExpertuptsiINSTITUT_ASIA";

    $method = "AES-128-CTR";
    $option = 0;
    $iv2 = "1251632135716362";
    
    $key_size =  strlen($key);
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
    $ciphertext = $iv . $ciphertext;

    $dataTerenkripsi=openssl_encrypt($ciphertext, $method, $key, $option, $iv2);
    
    $ciphertext_base64 = base64_encode(base64_encode($dataTerenkripsi));
