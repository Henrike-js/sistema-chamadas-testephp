<?php
// ================= CONFIGURAÇÃO =================
$arquivo = 'registros_chamadas.json';

// ================= VALIDA ID =================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Chamada inválida.");
}

$id = (int) $_GET['id'];

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
$c = null;

foreach ($registros as $r) {
    if ((int)$r['id_chamada'] === $id) {
        $c = $r;
        break;
    }
}

if (!$c) {
    die("Registro não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Relatório — Chamada <?= (int)$c['id_chamada'] ?></title>

<link rel="stylesheet" href="chamadas.css">

<style>
.report-container{background:#fff;border-radius:18px;padding:24px;box-shadow:var(--shadow-soft)}
.section{margin-top:22px;padding:16px;border:1px solid var(--border-soft);border-radius:14px;background:#fafafa}
.section h2{margin-bottom:10px;font-size:18px;font-weight:700}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:12px 18px}
.item{background:#fff;border:1px solid var(--border-soft);border-radius:12px;padding:10px 14px}
.label{font-size:12px;color:var(--text-muted)}
.value{font-weight:700}

/* BOTÃO COPIAR */
.copy-box{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:10px;
}
.copy-btn{
  background:#eaeaea;
  border:none;
  border-radius:8px;
  padding:6px 10px;
  cursor:pointer;
  font-size:14px;
  transition:.2s;
}
.copy-btn:hover{background:#d0d0d0;}
.copy-btn.copied{
  background:#4CAF50;
  color:#fff;
}
</style>
</head>

<body>

<div class="page">

<div class="topbar">
  <div class="topbar-inner">
    <div class="logo-wrapper"><img src="logo.png"></div>
    <div class="clock-wrapper">
      <div class="clock-time" id="clock"></div>
      <div class="clock-date" id="date"></div>
    </div>
  </div>
</div>

<main class="main">
<div class="main-inner">

<div class="page-header">
<h1>ID CHAMADA: <?= (int)$c['id_chamada'] ?></h1>
<p>Relatório completo da ocorrência</p>
</div>

<div class="report-container">

<?php
function campo($valor){
    $valor = $valor !== '' ? $valor : '-';
    return '<div class="value copy-box"><span class="copy-text">'.$valor.'</span><button class="copy-btn" onclick="copiarTexto(this)">📋</button></div>';
}
?>

<!-- ================= DADOS DO ATENDIMENTO ================= -->
<div class="section">
<h2>Dados do Atendimento</h2>
<div class="grid">

<div class="item"><div class="label">Data</div><?= campo($c['data_atendimento'] ?? '') ?></div>
<div class="item"><div class="label">Hora</div><?= campo($c['hora_atendimento'] ?? '') ?></div>
<div class="item"><div class="label">Matrícula</div><?= campo($c['matricula'] ?? '') ?></div>
<div class="item"><div class="label">Teleatendente</div><?= campo($c['nome_teleatendente'] ?? '') ?></div>

</div>
</div>

<!-- ================= SOLICITANTE ================= -->
<div class="section">
<h2>Solicitante</h2>
<div class="grid">

<div class="item"><div class="label">Nome</div><?= campo($c['nome_solicitante'] ?? '') ?></div>
<div class="item"><div class="label">Telefone</div><?= campo($c['telefone_chamada'] ?? '') ?></div>
<div class="item"><div class="label">Endereço</div><?= campo(($c['logradouro_chamada'] ?? '')." , ".($c['numero_chamada'] ?? '')) ?></div>
<div class="item"><div class="label">Bairro</div><?= campo($c['bairro_chamada'] ?? '') ?></div>
<div class="item"><div class="label">Município</div><?= campo($c['municipio_chamada'] ?? '') ?></div>

</div>
</div>

<!-- ================= NATUREZA ================= -->
<div class="section">
<h2>Natureza</h2>
<div class="grid">

<div class="item"><div class="label">Código</div><?= campo($c['codigo_natureza'] ?? '') ?></div>
<div class="item"><div class="label">Histórico</div><?= campo(nl2br(htmlspecialchars($c['descricao_natureza'] ?? ''))) ?></div>

</div>
</div>

<!-- ================= DESPACHO ================= -->
<div class="section">
<h2>Despacho</h2>
<div class="grid">

<div class="item"><div class="label">Despachador</div><?= campo($c['despachador_nome'] ?? '') ?></div>
<div class="item"><div class="label">Matrícula</div><?= campo($c['despachador_matricula'] ?? '') ?></div>
<div class="item"><div class="label">Data</div><?= campo($c['data_despacho'] ?? '') ?></div>
<div class="item"><div class="label">Hora</div><?= campo($c['hora_despacho'] ?? '') ?></div>
<div class="item"><div class="label">Recurso</div><?= campo($c['recurso'] ?? '') ?></div>
<div class="item"><div class="label">Unidade</div><?= campo($c['unidade'] ?? '') ?></div>
<div class="item"><div class="label">Despachada</div><?= campo($c['hora_despachada'] ?? '') ?></div>
<div class="item"><div class="label">A caminho</div><?= campo($c['hora_a_caminho'] ?? '') ?></div>
<div class="item"><div class="label">No local</div><?= campo($c['hora_no_local'] ?? '') ?></div>
<div class="item"><div class="label">Encerramento</div><?= campo($c['encerramento'] ?? '') ?></div>
<div class="item"><div class="label">Classificação</div><?= campo($c['classificacao'] ?? '') ?></div>
<div class="item"><div class="label">Natureza Final</div><?= campo($c['codigo_natureza_final'] ?? '') ?></div>
<div class="item"><div class="label">Descrição Final</div><?= campo(nl2br(htmlspecialchars($c['descricao_natureza_final'] ?? ''))) ?></div>
<div class="item"><div class="label">NR PM</div><?= campo($c['nr_pm'] ?? '') ?></div>
<div class="item"><div class="label">Comentários</div><?= campo(nl2br(htmlspecialchars($c['comentarios'] ?? ''))) ?></div>

</div>
</div>

<a href="chamadas.php">← Voltar</a>

</div>
</div>
</main>
</div>

<script>
function copiarTexto(btn){
    const text = btn.closest('.copy-box').querySelector('.copy-text').innerText;
    navigator.clipboard.writeText(text).then(()=>{
        btn.classList.add('copied');
        btn.innerText = "✔";
        setTimeout(()=>{
            btn.classList.remove('copied');
            btn.innerText = "📋";
        },1500);
    });
}
</script>

</body>
</html>

