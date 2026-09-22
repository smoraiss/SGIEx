<?php

class Ferramentas{

    public $param;
    public $senha;

    public function antiInjection($param) {
        // Define as palavras-chave e caracteres potencialmente perigosos
        $palavras = array(
            "from", "select", "insert", "delete", "where", "drop", "table", "show", 
            "update", "declare", "exec", "set", "alter", "cst", "union", "column", 
            "*", "%", "\"", "'", "\\", "--"
        );
        
        // Converte a string para minúsculas
        $paramL = strtolower($param);
        
        // Remove as palavras-chave e caracteres da string
        $str = str_replace($palavras, "", $paramL);
        
        // Compara o comprimento da string original com a string modificada
        if (strlen($param) != strlen($str)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function sha256($senha){
        $senhaCript = hash('sha256', $senha);
        return $senhaCript;
    }

    public function geradorStringRandom($length) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $var_size = strlen($chars);
        $random_str = "";
        for ($x = 0; $x < $length; $x++) {
            $random_str .= $chars[random_int(0, $var_size - 1)];
        }
        return $random_str;
    }

    public function pegaExtensao($arq) {
        $ext = explode('.', $arq);
        var_dump($ext);
        return end($ext);  // Return the last part after splitting by dots
    }

    public function geradorMicroTime() {
        $time = microtime(true);
        $valor = explode('.', $time);
        return $valor[0];
    }

private static function chave(): string
    {
        $chave = Env::get('APP_KEY');

        if (!$chave) {
            throw new RuntimeException('APP_KEY não configurada.');
        }

        $chaveBinaria = hex2bin($chave);

        if ($chaveBinaria === false || strlen($chaveBinaria) !== 32) {
            throw new RuntimeException('APP_KEY inválida.');
        }

        return $chaveBinaria;
    }

    public static function criptografar(string $dados): string
    {
        $iv = openssl_cipher_iv_length('aes-256-gcm');
        $tag = '';

        $criptografado = openssl_encrypt(
            $dados,
            'aes-256-gcm',
            self::chave(),
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($criptografado === false) {
            throw new RuntimeException('Falha ao criptografar os dados.');
        }
        return base64_encode($iv . $tag . $criptografado);
    }
    public static function descriptografar(string $dados)
    {
        $dados = base64_decode($dados, true);

        if ($dados === false) {
            return false;
        }

        $ivTam = openssl_cipher_iv_length('aes-256-gcm');
        $tagTam = 16;

        if (strlen($dados) <= $ivTam + $tagTam) {
            return false;
        }

        $iv = substr($dados, 0, $ivTam);
        $tag = substr($dados, $ivTam, $tagTam);
        $criptografado = substr($dados, $ivTam + $tagTam);

        return openssl_decrypt(
            $criptografado,
            'aes-256-gcm',
            self::chave(),
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
    }

public function unsetCookie($name) {
    setcookie($name, '', time() - 3600, '/');
}

}
?>