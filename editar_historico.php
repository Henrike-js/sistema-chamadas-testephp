<?php
// ================== CONFIGURAÇÃO ==================
$arquivo = 'registros_chamadas.json';

// ================== SALVAR ==================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;
    $historico_existente = $_POST['historico_existente'] ?? '';
    $novo_texto = trim($_POST['novo_texto'] ?? '');

    if ($id && $novo_texto !== "" && file_exists($arquivo)) {

        $json = file_get_contents($arquivo);
        $registros = json_decode($json, true);

        if (!is_array($registros)) {
            die("Erro ao ler os dados.");
        }

        foreach ($registros as &$r) {
            if ((int)$r['id_chamada'] === (int)$id) {

                $data = date("d/m/Y H:i");

                $r['historico'] =
                    $historico_existente .
                    "\n\n---- Adicionado em $data ----\n" .
                    $novo_texto;

                break;
            }
        }

        // Salva de volta no JSON
        file_put_contents(
            $arquivo,
            json_encode($registros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        header("Location: lista_chamadas.php?ok=1");
        exit;
    }
}

// ================== CARREGAR REGISTRO ==================
$id = $_GET['id'] ?? null;

if (!$id || !file_exists($arquivo)) {
    die("Chamada não encontrada.");
}

$json = file_get_contents($arquivo);
$registros = json_decode($json, true);

if (!is_array($registros)) {
    die("Erro ao ler os dados.");
}

$registro = null;

foreach ($registros as $r) {
    if ((int)$r['id_chamada'] === (int)$id) {
        $registro = $r;
        break;
    }
}

if (!$registro) {
    die("Registro não localizado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Editar Histórico</title>

<style>
body{font-family:Arial;background:#f4f4f4;padding:20px}
form{background:white;padding:20px;border-radius:8px;max-width:700px}
textarea{width:100%;border:1px solid #ccc;border-radius:6px;padding:10px}
small{color:#666}
button{padding:10px 18px;background:#16325C;color:white;border:0;border-radius:6px;cursor:pointer}
a{margin-left:10px}
</style>
</head>

<body>

<h2>Editar Histórico – Chamada #<?= htmlspecialchars($registro['id_chamada']) ?></h2>

<form method="post">

    <input type="hidden" name="id" value="<?= htmlspecialchars($registro['id_chamada']) ?>">

    <label>Histórico atual (não pode alterar)</label><br>
    <textarea readonly rows="8"><?= htmlspecialchars($registro['historico'] ?? '') ?></textarea>

    <input type="hidden" name="historico_existente"
           value="<?= htmlspecialchars($registro['historico'] ?? '') ?>">

    <br><br>

    <label>Adicionar novo registro</label>
    <small>(o texto será anexado ao histórico)</small>

    <textarea name="novo_texto" rows="6" placeholder="Digite o complemento..."></textarea>

    <br><br>

    <button type="submit">Salvar</button>
    <a href="lista_chamadas.php">Cancelar</a>

</form>

</body>
</html>
