<?php

namespace App\APP_NAME\Config;
/**
*
*/
define('WALLET_GLOBAL_KEY', 'YhOLEBdTU1PvxHg9lIEJqKVi4xxXFv02');
define('PASSWORD_APPEND', '1PvxHg9lIEJq');

Trait StringEncrypt
{

	protected $keys;

	function randEnc(int $length, string $type = '') {
		$char = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
		if($type == "Numeric"){
			$char = array_merge(range(0,9));
		} elseif ($type == "Alphabet") {
			$char = array_merge(range('a', 'z'),range('A', 'Z'));
		}

		$val = '';
		for($i=0; $i < $length; $i++) {
			$val .= $char[mt_rand(0, count($char) - 1)];
		}
		return $val;
	}

	public function encryptString($str, string $ky)
	{
			$ky = preg_replace('#[ ]#i', '', $ky);
			$len = openssl_cipher_iv_length($cipher = "AES-128-CBC");
			$iv = openssl_random_pseudo_bytes($len);
			$str = str_rot13($str);
			$cstr = openssl_encrypt($str, $cipher, $ky,$options=OPENSSL_RAW_DATA,$iv);
			$hmac = hash_hmac('sha256', $cstr, $ky,$as_binary=true);
			$cdata = base64_encode($iv.$hmac.$cstr);

			$rand5 = $this->randEnc(11, '');
			$rand6 = $this->randEnc(12, '');
			$rand6 = $rand6.'==';

			$cdata = 'ENCRYPTED_'.time().' <<< '.$rand5.''.$cdata.''.$rand6.' >>> END';
			return $cdata;
	}

	public function decryptString($str, string $ky)
	{
			if(is_bool($str) || empty($str)){return $str;}
			$ky = preg_replace('#[ ]#i', '', $ky);
			if (count(explode('<<<', $str)) == 2 && count(explode('>>>', $str)) == 2) {
				# code...
			$str = @explode('>>>', explode('<<<', $str)[1])[0];
			if (!empty($str)) {
			$str = substr($str, 12);
			$str = substr($str,0, (strlen($str) - 15));
			$c = base64_decode($str);
			$len = openssl_cipher_iv_length($cipher = "AES-128-CBC");
			$iv = substr($c, 0, $len);
			$hmac = substr($c,$len, $shalen = 32);
			$cr = substr($c, $len+$shalen);
			$op = openssl_decrypt($cr, $cipher, $ky, $options=OPENSSL_RAW_DATA,$iv);
			$cm = hash_hmac('sha256', $cr, $ky,$as_binary=true);

			return str_rot13($op);
			// if (hash_equals($hmac, $cm)) {
			//  } else {
			//  return str_rot13($op);
			//  }
			} else {
				return false;
			}

			} else {
				return false;
			}

	}


	public function crypt_pass(string $pass, string $key)
	{
		// encryption
			$enc_1 = $this->randEnc(6, '');
			$enc_2 = $this->randEnc(6, '');

			$mdp = md5($pass);
			$mdp = $mdp . PASSWORD_APPEND;
			$cryp = crc32($mdp);
			$encp = base64_encode($cryp);
			$token = hash('ripemd128', $enc_1.$encp.$enc_2);
			$dbPass = $this->encryptString($token, $key);

			return ['password' => $dbPass, 'before' => $enc_1, 'after' => $enc_2];
							// end password
	}

public function decrypt_pass(string $pass, array $obj)
{
	$enc_1 = $obj['before_key'];
	$enc_2 = $obj['after_key'];

	$mdp = md5($pass);
	$mdp = $mdp . PASSWORD_APPEND;
	$cryp = crc32($mdp);
	$encp = base64_encode($cryp);
	$token = hash('ripemd128', $enc_1.$encp.$enc_2);
 	return $token;
}

	}
