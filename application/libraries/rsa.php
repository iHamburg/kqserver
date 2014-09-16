    <?php  
    /** 
     * RSA算法类 
     * 签名及密文编码：base64字符串/十六进制字符串/二进制字符串流 
     * 填充方式: PKCS1Padding（加解密）/NOPadding（解密） 
     * 
     * Notice:Only accepts a single block. Block size is equal to the RSA key size!  
     * 如密钥长度为1024 bit，则加密时数据需小于128字节，加上PKCS1Padding本身的11字节信息，所以明文需小于117字节 
     * 
     * @author: linvo 
     * @version: 1.0.0 
     * @date: 2013/1/23 
     */  
    class Rsa{  
      
        private $priKey = '-----BEGIN RSA PRIVATE KEY-----  
MIICXQIBAAKBgQC3//sR2tXw0wrC2DySx8vNGlqt3Y7ldU9+LBLI6e1KS5lfc5jl  
TGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2klBd6h4wrbbHA2XE1sq21ykja/  
Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o2n1vP1D+tD3amHsK7QIDAQAB  
AoGBAKH14bMitESqD4PYwODWmy7rrrvyFPEnJJTECLjvKB7IkrVxVDkp1XiJnGKH  
2h5syHQ5qslPSGYJ1M/XkDnGINwaLVHVD3BoKKgKg1bZn7ao5pXT+herqxaVwWs6  
ga63yVSIC8jcODxiuvxJnUMQRLaqoF6aUb/2VWc2T5MDmxLhAkEA3pwGpvXgLiWL  
3h7QLYZLrLrbFRuRN4CYl4UYaAKokkAvZly04Glle8ycgOc2DzL4eiL4l/+x/gaq  
deJU/cHLRQJBANOZY0mEoVkwhU4bScSdnfM6usQowYBEwHYYh/OTv1a3SqcCE1f+  
qbAclCqeNiHajCcDmgYJ53LfIgyv0wCS54kCQAXaPkaHclRkQlAdqUV5IWYyJ25f  
oiq+Y8SgCCs73qixrU1YpJy9yKA/meG9smsl4Oh9IOIGI+zUygh9YdSmEq0CQQC2  
4G3IP2G3lNDRdZIm5NZ7PfnmyRabxk/UgVUWdk47IwTZHFkdhxKfC8QepUhBsAHL  
QjifGXY4eJKUBm3FpDGJAkAFwUxYssiJjvrHwnHFbg0rFkvvY63OSmnRxiL4X6EY  
yI9lblCsyfpl25l7l5zmJrAHn45zAiOoBrWqpM5edu7c  
-----END RSA PRIVATE KEY-----';  
        
        private $pubKey = '-----BEGIN PUBLIC KEY-----  
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt  
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl  
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o  
2n1vP1D+tD3amHsK7QIDAQAB  
-----END PUBLIC KEY-----';  
      
        /** 
         * 自定义错误处理 
         */  
        private function _error($msg){  
            die('RSA Error:' . $msg); //TODO  
        }  
      
        /** 
         * 构造函数 
         * 
         * @param string 公钥文件（验签和加密时传入） 
         * @param string 私钥文件（签名和解密时传入） 
         */  
        public function __construct($public_key_file = '', $private_key_file = ''){  
            if ($public_key_file){  
                $this->_getPublicKey($public_key_file);  
            }  
            if ($private_key_file){  
                $this->_getPrivateKey($private_key_file);  
            }  
        }  
      
      
        /** 
         * 生成签名 
         * 
         * @param string 签名材料 
         * @param string 签名编码（base64/hex/bin） 
         * @return 签名值 
         */  
        public function sign($data, $code = 'base64'){  
            $ret = false;  
            if (openssl_sign($data, $ret, $this->priKey)){  
                $ret = $this->_encode($ret, $code);  
            }  
            return $ret;  
        }  
      
        /** 
         * 验证签名 
         * 
         * @param string 签名材料 
         * @param string 签名值 
         * @param string 签名编码（base64/hex/bin） 
         * @return bool  
         */  
        public function verify($data, $sign, $code = 'base64'){  
            $ret = false;      
            $sign = $this->_decode($sign, $code);  
            if ($sign !== false) {  
                switch (openssl_verify($data, $sign, $this->pubKey)){  
                    case 1: $ret = true; break;      
                    case 0:      
                    case -1:       
                    default: $ret = false;       
                }  
            }  
            return $ret;  
        }  
      
        /** 
         * 加密 
         * 
         * @param string 明文 
         * @param string 密文编码（base64/hex/bin） 
         * @param int 填充方式（貌似php有bug，所以目前仅支持OPENSSL_PKCS1_PADDING） 
         * @return string 密文 
         */  
        public function encrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING){  
            $ret = false;      
            if (!$this->_checkPadding($padding, 'en')) $this->_error('padding error');  
            if (openssl_public_encrypt($data, $result, $this->pubKey, $padding)){  
                $ret = $this->_encode($result, $code);  
            }  
            return $ret;  
        }  
      
        /** 
         * 解密 
         * 
         * @param string 密文 
         * @param string 密文编码（base64/hex/bin） 
         * @param int 填充方式（OPENSSL_PKCS1_PADDING / OPENSSL_NO_PADDING） 
         * @param bool 是否翻转明文（When passing Microsoft CryptoAPI-generated RSA cyphertext, revert the bytes in the block） 
         * @return string 明文 
         */  
        public function decrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING, $rev = false){  
            $ret = false;  
            $data = $this->_decode($data, $code);  
            if (!$this->_checkPadding($padding, 'de')) $this->_error('padding error');  
            if ($data !== false){  
                if (openssl_private_decrypt($data, $result, $this->priKey, $padding)){  
                    $ret = $rev ? rtrim(strrev($result), "\0") : ''.$result;  
                }   
            }  
            return $ret;  
        }  
      
      
        // 私有方法  
      
        /** 
         * 检测填充类型 
         * 加密只支持PKCS1_PADDING 
         * 解密支持PKCS1_PADDING和NO_PADDING 
         *  
         * @param int 填充模式 
         * @param string 加密en/解密de 
         * @return bool 
         */  
        private function _checkPadding($padding, $type){  
            if ($type == 'en'){  
                switch ($padding){  
                    case OPENSSL_PKCS1_PADDING:  
                        $ret = true;  
                        break;  
                    default:  
                        $ret = false;  
                }  
            } else {  
                switch ($padding){  
                    case OPENSSL_PKCS1_PADDING:  
                    case OPENSSL_NO_PADDING:  
                        $ret = true;  
                        break;  
                    default:  
                        $ret = false;  
                }  
            }  
            return $ret;  
        }  
      
        private function _encode($data, $code){  
            switch (strtolower($code)){  
                case 'base64':  
                    $data = base64_encode(''.$data);  
                    break;  
                case 'hex':  
                    $data = bin2hex($data);  
                    break;  
                case 'bin':  
                default:  
            }  
            return $data;  
        }  
      
        private function _decode($data, $code){  
            switch (strtolower($code)){  
                case 'base64':  
                    $data = base64_decode($data);  
                    break;  
                case 'hex':  
                    $data = $this->_hex2bin($data);  
                    break;  
                case 'bin':  
                default:  
            }  
            return $data;  
        }  
      
        private function _getPublicKey($file){  
            $key_content = $this->_readFile($file);  
            if ($key_content){  
                $this->pubKey = openssl_get_publickey($key_content);  
            }  
        }  
      
        private function _getPrivateKey($file){  
            $key_content = $this->_readFile($file);  
            if ($key_content){  
                $this->priKey = openssl_get_privatekey($key_content);  
            }  
        }  
      
        private function _readFile($file){  
            $ret = false;  
            if (!file_exists($file)){  
                $this->_error("The file {$file} is not exists");  
            } else {  
                $ret = file_get_contents($file);  
            }  
            return $ret;  
        }  
      
      
        private function _hex2bin($hex = false){  
            $ret = $hex !== false && preg_match('/^[0-9a-fA-F]+$/i', $hex) ? pack("H*", $hex) : false;      
            return $ret;  
        }  
      
      
      
    }  