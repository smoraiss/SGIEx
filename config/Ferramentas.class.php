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

public function criptografar($message, $key)
{
    $chaveTam = strlen($key);
    $mensagemTam = strlen($message);
    $criptoMsg = '';
    for ($i = 0; $i < $mensagemTam; $i++) {
        $criptoMsg .= $message[$i] ^ $key[$i % $chaveTam];
    }
    $criptoMsg .= $key;
    return base64_encode($criptoMsg);
}
 
public function descriptografar($encryptedMessage, $key)
{
    $decodedMessage = base64_decode($encryptedMessage);
    $chaveTam = strlen($key);
    $chaveExtr = substr($decodedMessage, -$chaveTam);
    if ($chaveExtr !== $key) {
        return false; // chave errada
    }
    $encodedMessage = substr($decodedMessage, 0, -$chaveTam);
    $mensagemTam = strlen($encodedMessage);
    $decryptedMessage = '';
 
    for ($i = 0; $i < $mensagemTam; $i++) {
        $decryptedMessage .= $encodedMessage[$i] ^ $key[$i % $chaveTam];
    }
    return $decryptedMessage;
}

public function unsetCookie($name) {
    setcookie($name, '', time() - 3600, '/');
}

}
?>