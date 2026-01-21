<?php
// ================= CONFIGURAÇÃO =================
$arquivo ='registros_chamadas.json';

// ================= VALIDA ID =================
$chamada_id = isset($_POST['chamada_id']) ? (int)$_POST['chamada_id'] : 0;

if (!$chamada_id) {
    die("Chamada inválida.");
}

// ================= LÊ JSON =================
if (!file_exists($arquivo)) {
    die("Arquivo de dados não encontrado.");
}

$json = file_get_contents($arquivo);
$registros = json_decode($json, true);

if (!is_array($registros)) {
    die("Erro ao ler os dados.");
}

// ================= LOCALIZA REGISTRO =================
$encontrado = false;

foreach ($registros as &$r) {
    if ((int)$r['id_chamada'] === $chamada_id) {

        // -------- DADOS DO DESPACHADOR --------
        $r['despachador_matricula'] = $_POST['matricula'] ?? '';
        $r['despachador_nome']      = $_POST['nome'] ?? '';
        $r['data_despacho']         = $_POST['data'] ?? '';
        $r['hora_despacho']         = $_POST['hora'] ?? '';

        // -------- STATUS DO RECURSO --------
        $r['recurso']               = $_POST['recurso'] ?? '';
        $r['unidade']               = $_POST['unidade'] ?? '';
        $r['hora_despachada']       = $_POST['hora_despachada'] ?? '';
        $r['hora_a_caminho']        = $_POST['hora_a_caminho'] ?? '';
        $r['hora_no_local']         = $_POST['hora_no_local'] ?? '';
        $r['encerramento']          = $_POST['encerramento'] ?? '';

        // -------- CLASSIFICAÇÃO --------
        $r['classificacao']               = $_POST['classificacao'] ?? '';
        $r['observacao_classificacao']    = $_POST['observacao_classificacao'] ?? '';

        // -------- NATUREZA FINAL --------
        $r['descricao_natureza_final'] = $_POST['descricao_natureza_final'] ?? '';
        $r['codigo_natureza_final']    = $_POST['codigo_natureza_final'] ?? '';
        $r['nr_pm']                    = $_POST['nr_pm'] ?? '';
        $r['comentarios']              = $_POST['comentarios'] ?? '';

        // -------- STATUS DA CHAMADA --------
        $r['status'] = empty($_POST['encerramento'])
            ? 'encaminhada'
            : 'encerrada';

        $encontrado = true;
        break;
    }
}

if (!$encontrado) {
    die("Registro não encontrado.");
}

// ================= SALVA JSON =================
file_put_contents(
    $arquivo,
    json_encode($registros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

// ================= REDIRECIONA =================
header("Location: mensagem_finalizacao.php?chamada=".$chamada_id);
exit;
