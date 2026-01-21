<?php
// ================= CONFIGURAÇÃO =================
$arquivo = 'registros_chamadas.json';
$busca = isset($_GET['q']) ? trim($_GET['q']) : "";

// ================= LÊ JSON =================
if (!file_exists($arquivo)) {
    die("Arquivo de dados não encontrado.");
}

$json = file_get_contents($arquivo);
$registros = json_decode($json, true);

if (!is_array($registros)) {
    die("Erro ao ler os dados.");
}

// ================= FILTRO (BUSCA) =================
if ($busca !== "") {
    $registros = array_filter($registros, function ($c) use ($busca) {
        return
            stripos((string)($c['id_chamada'] ?? ''), $busca) !== false ||
            stripos($c['nome_solicitante'] ?? '', $busca) !== false ||
            stripos($c['telefone_chamada'] ?? '', $busca) !== false ||
            stripos($c['municipio_chamada'] ?? '', $busca) !== false ||
            stripos($c['codigo_natureza'] ?? '', $busca) !== false ||
            stripos($c['status'] ?? '', $busca) !== false;
    });
}

// ================= ORDENAÇÃO =================
usort($registros, function ($a, $b) {
    return ($b['id_chamada'] ?? 0) <=> ($a['id_chamada'] ?? 0);
});

// ================= LIMITE =================
$registros = array_slice($registros, 0, 200);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chamadas Registradas</title>

<style>
/* ===== VARIÁVEIS ===== */
:root{
  --primary:#2f5dff;
  --bg:#f5f7fb;
  --text:#111827;
  --muted:#6b7280;
  --border:#e5e7eb;
  --radius:16px;
}

/* ===== BASE ===== */
*{margin:0;padding:0;box-sizing:border-box}
body{
  font-family:Arial,Helvetica,sans-serif;
  background:var(--bg);
  color:var(--text);
}

.page{max-width:1200px;margin:auto;padding:20px}

/* ===== TOPO ===== */
.topbar{
  background:#fff;
  padding:14px 20px;
  border-bottom:1px solid var(--border);
  margin:-20px -20px 20px -20px;
}
.header{
  display:flex;
  align-items:center;
  gap:16px;
}
.header img{height:70px}
.header h1{font-size:22px}
.header p{font-size:13px;color:var(--muted)}

/* ===== BUSCA ===== */
.search-box{
  display:flex;
  gap:10px;
  margin-bottom:20px;
}
.search-box input{
  width:100%;
  padding:12px;
  border-radius:12px;
  border:1px solid var(--border);
}
.search-box button{
  padding:12px 20px;
  border:none;
  border-radius:12px;
  background:var(--primary);
  color:#fff;
  font-weight:700;
  cursor:pointer;
}
.search-box button:hover{opacity:.9}

/* ===== TABELA ===== */
.table-wrapper{
  background:#fff;
  border-radius:var(--radius);
  overflow:hidden;
  box-shadow:0 10px 25px rgba(0,0,0,.06);
}
table{width:100%;border-collapse:collapse}
th,td{
  padding:14px 12px;
  border-bottom:1px solid var(--border);
  font-size:14px;
}
th{background:#f3f4f6;text-align:left}
tr.row-link{cursor:pointer}
tr.row-link:hover td{background:#eef2ff}

/* ===== STATUS ===== */
.status-pill{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:6px 12px;
  border-radius:20px;
  font-size:12px;
  font-weight:700;
}
.status-dot{width:8px;height:8px;border-radius:50%}
.status-aberta{background:#fdecea;color:#c62828}
.status-aberta .status-dot{background:#e53935}
.status-encaminhada{background:#e8f5e9;color:#2e7d32}
.status-encaminhada .status-dot{background:#43a047}
.status-fechada{background:#eee;color:#000}
.status-fechada .status-dot{background:#000}

/* ===== MOBILE ===== */
@media(max-width:760px){
  table,thead,tbody,th,td,tr{display:block}
  thead{display:none}
  tr{
    margin-bottom:12px;
    border:1px solid var(--border);
    border-radius:var(--radius);
    padding:10px;
  }
  td{border:none;padding:6px}
  td::before{
    content:attr(data-label);
    font-size:12px;
    color:var(--muted);
    display:block;
  }
}
</style>
</head>

<body>

<div class="page">

<div class="topbar">
  <div class="header">
    <img src="logo.png">
    <div>
      <h1>Chamadas Registradas</h1>
      <p>Lista geral das chamadas no sistema</p>
    </div>
  </div>
</div>

<form class="search-box">
  <input name="q" placeholder="Buscar..." value="<?= htmlspecialchars($busca) ?>">
  <button>Buscar</button>
</form>

<div class="table-wrapper">
<table>
<thead>
<tr>
  <th>#</th>
  <th>Solicitante</th>
  <th>Telefone</th>
  <th>Município</th>
  <th>Natureza</th>
  <th>Status</th>
  <th>Atendimento</th>
</tr>
</thead>
<tbody>

<?php if($registros): foreach($registros as $c): ?>
<tr class="row-link" onclick="location='relatoriocompleto.php?id=<?= (int)$c['id_chamada'] ?>'">

<td data-label="#"><?= (int)$c['id_chamada'] ?></td>
<td data-label="Solicitante"><?= htmlspecialchars($c['nome_solicitante'] ?? '') ?></td>
<td data-label="Telefone"><?= htmlspecialchars($c['telefone_chamada'] ?? '') ?></td>
<td data-label="Município"><?= htmlspecialchars($c['municipio_chamada'] ?? '') ?></td>
<td data-label="Natureza"><?= htmlspecialchars($c['codigo_natureza'] ?? '') ?></td>

<td data-label="Status">
<?php
$s = $c['status'] ?? '';
if($s==='aberto') echo '<span class="status-pill status-aberta"><span class="status-dot"></span>Aberta</span>';
elseif($s==='encaminhada') echo '<span class="status-pill status-encaminhada"><span class="status-dot"></span>Encaminhada</span>';
elseif($s==='encerrada') echo '<span class="status-pill status-fechada"><span class="status-dot"></span>Fechada</span>';
?>
</td>

<td data-label="Atendimento">
<?= !empty($c['data_atendimento']) ? date('d/m/Y',strtotime($c['data_atendimento'])) : '-' ?>
às <?= substr($c['hora_atendimento'] ?? '',0,5) ?>
</td>

</tr>
<?php endforeach; else: ?>
<tr><td colspan="7" style="text-align:center;padding:20px">Nenhum registro encontrado</td></tr>
<?php endif; ?>

</tbody>
</table>
</div>

</div>

</body>
</html>
