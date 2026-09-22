<?php
function e(mixed $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $path): never { header('Location: ' . $path); exit; }
function input(string $key, string $default = ''): string { return trim((string)($_POST[$key] ?? $default)); }
