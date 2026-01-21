<?php
// ================= CONFIGURAÇÃO =================
$arquivo = 'registros_chamadas.json';

// ================= RECEBE DADOS DO FETCH =================
$data = json_decode(file_get_contents("php://input"), true);

$id = isset($data['id']) ? (int)$data['id'] : 0;
$batalhao = trim($data['batalhao'] ?? '');

if (!$id || $batalhao === '') {
    http_response_code(400);
    echo "Dados inválidos";
    exit;
}

// ================= LÊ JSON =================
if (!file_exists($arquivo)) {
    http_response_code(500);
    echo "Arquivo não encontrado";
    exit;
}

$json = file_get_contents($arquivo);
$registros = json_decode($json, true);

if (!is_array($registros)) {
    http_response_code(500);
    echo "Erro ao ler JSON";
    exit;
}

// ================= ATUALIZA REGISTRO =================
$encontrado = false;

foreach ($registros as &$r) {
    if ((int)$r['id_chamada'] === $id) {
        $r['batalhao'] = $batalhao;
        $encontrado = true;
        break;
    }
}

if (!$encontrado) {
    http_response_code(404);
    echo "Registro não encontrado";
    exit;
}

// ================= SALVA JSON =================
file_put_contents(
    $arquivo,
    json_encode($registros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

// ================= OK =================
echo "OK";
