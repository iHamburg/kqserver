<?php
class aes {
 
    // CRYPTO_CIPHER_BLOCK_SIZE 32
     
//    private $_secret_key = '1aabac6d068eef6a7bad3fdf50a05cc8';
     private $_secret_key = 'lvANHSNZCYTZRNmX'; 
	
    public function setKey($key) {
        $this->_secret_key = $key;
    }
     
    public function encode($data) {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td),MCRYPT_RAND);
        mcrypt_generic_init($td,$this->_secret_key,$iv);
        $encrypted = mcrypt_generic($td,$data);
        mcrypt_generic_deinit($td);
         
        return $iv . $encrypted;
    }
     
	public static function AesEncrypt($plaintext,$key = null)
    {
        $plaintext = trim($plaintext);
        if ($plaintext == '') return '';
     
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
//        $key=self::substr($key===null ? Yii::app()->params['encryptKey'] : $key, 0, mcrypt_enc_get_key_size($module));
        /* Create the IV and determine the keysize length, use MCRYPT_RAND
         * on Windows instead */
        $iv = substr(md5($key),0,mcrypt_enc_get_iv_size($module));
        /* Intialize encryption */
        mcrypt_generic_init($module, $key, $iv);
 
        /* Encrypt data */
        $encrypted = mcrypt_generic($module, $plaintext);
 
        /* Terminate encryption handler */
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);
        return base64_encode($encrypted);
    }
    
    public function decode($data) {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
        $iv = mb_substr($data,0,32,'latin1');
        mcrypt_generic_init($td,$this->_secret_key,$iv);
        $data = mb_substr($data,32,mb_strlen($data,'latin1'),'latin1');
        $data = mdecrypt_generic($td,$data);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
         
        return trim($data);
    }
}
 
$aes = new aes();
$aes->setKey('key');
 
// 加密
$string = $aes->encode('string');
// 解密
$aes->decode($string);
