<?php

class Env
{
    private static array $dados = [];

    public static function load(string $arquivo): void{
        if (!file_exists($arquivo)) {
            throw new RuntimeException('.env não encontrado.');
        }

        $linhas = file(
            $arquivo,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );

        foreach ($linhas as $linha) {
            $linha = trim($linha);

            if ($linha === '' || str_starts_with($linha, '#')) {
                continue;
            }

            [$nome, $valor] = array_pad(
                explode('=', $linha, 2),
                2,
                ''
            );

            self::$dados[trim($nome)] = trim($valor);
        }
    }

    public static function get(string $nome, $padrao = null)
    {
        return self::$dados[$nome] ?? $padrao;
    }
}