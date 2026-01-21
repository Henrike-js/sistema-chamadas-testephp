<?php

// ===== RECEBENDO DADOS =====
$dados = $_POST;

// CHECKBOX → vira string "190,197,193"
if (isset($dados['destino_servico']) && is_array($dados['destino_servico'])) {
    $dados['destino_servico'] = implode(",", $dados['destino_servico']);
}

// Adiciona data/hora de salvamento
$dados['data_salvamento'] = date('Y-m-d H:i:s');

// Arquivo JSON
$arquivo = __DIR__ . "/registros_chamadas.json";

// Lê dados existentes
$registros = [];
if (file_exists($arquivo)) {
    $registros = json_decode(file_get_contents($arquivo), true);
    if (!is_array($registros)) {
        $registros = [];
    }
}

// Gera ID simples
$dados['id_chamada'] = count($registros) + 1;

// Salva novo registro
$registros[] = $dados;

file_put_contents(
    $arquivo,
    json_encode($registros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

// ===== RETORNO VISUAL =====
echo "
<div style='
    font-family: Arial;
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    width: 380px;
    margin: 40px auto;
    text-align: center;
    font-size: 18px;'>

    <strong>Chamada nº {$dados['id_chamada']}</strong> salva em arquivo JSON!<br><br>
    Redirecionando em <span id='contador'>10</span> segundos...
</div>

<script>
    let tempo = 10;
    let contador = document.getElementById('contador');
    setInterval(() => {
        tempo--;
        contador.textContent = tempo;
        if (tempo <= 0) {
            window.location.href = 'atendente_seu_formulario_integrado.php';
        }
    }, 1000);
</script>
";
