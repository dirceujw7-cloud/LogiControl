<?php
function h($valor): string {
    return htmlspecialchars((string)($valor ?? ''), ENT_QUOTES, 'UTF-8');
}
function redirecionar(string $caminho): void {
    header('Location: ' . $caminho);
    exit;
}
function valorPost(string $campo, string $padrao = ''): string {
    return trim((string)($_POST[$campo] ?? $padrao));
}
