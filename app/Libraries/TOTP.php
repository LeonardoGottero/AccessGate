<?php
namespace App\Libraries;
class TOTP {
    private $secret;
    private $digits;
    private $period;
    public function __construct($secret, $digits = 6, $period = 30) {
        $this->secret = $secret;
        $this->digits = $digits;
        $this->period = $period;
    }
    private function base32Decode($b32) {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $b32 = strtoupper($b32);
        $l = strlen($b32);
        $n = 0;
        $j = 0;
        $binary = "";
        for ($i = 0; $i < $l; $i++) {
            $n = $n << 5;
            $n = $n + strpos($alphabet, $b32[$i]);
            $j += 5;
            if ($j >= 8) {
                $j -= 8;
                $binary .= chr(($n & (0xFF << $j)) >> $j);
            }
        }
        return $binary;
    }
    public function generateCode($time = null) {
        if ($time === null) {
            $time = floor(time() / $this->period);
        }
        $key = $this->base32Decode($this->secret);
        $time = pack('N*', 0) . pack('N*', $time);
        $hash = hash_hmac('sha1', $time, $key, true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncatedHash = substr($hash, $offset, 4);
        $code = unpack('N', $truncatedHash)[1] & 0x7FFFFFFF;
        $code = $code % pow(10, $this->digits);
        return str_pad($code, $this->digits, '0', STR_PAD_LEFT);
    }
    public function verifyCode($code, $discrepancy = 2, $time = null) {
        if ($time === null) {
            $time = floor(time() / $this->period);
        }
        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            if ($this->generateCode($time + $i) === $code) {
                return true;
            }
        }
        return false;
    }
}
function generateSecret($length = 16) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $secret = '';
    for ($i = 0; $i < $length; $i++) {
        $secret .= $chars[random_int(0, 31)];
    }
    return $secret;
}
function getQrCodeUrl($secret, $usuario, $issuer, $digits = 6, $period = 30) {
    $encodedUsuario = rawurlencode($usuario);
    $encodedIssuer = rawurlencode($issuer);
    $otpauth = "otpauth://totp/{$encodedIssuer}:{$encodedUsuario}?secret={$secret}&issuer={$encodedIssuer}&algorithm=SHA1&digits={$digits}&period={$period}";
    return "https://quickchart.io/qr?size=200&level=M&text=" . urlencode($otpauth);
}