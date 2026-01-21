<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Sistema de Chamadas – MENU TESTE</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f3f4f6;
}
.container{
    max-width:1000px;
    margin:30px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}
h1{
    margin-top:0;
    color:#16325C;
}
p{
    color:#555;
}
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:18px;
    margin-top:25px;
}
.card{
    border:1px solid #e5e7eb;
    border-radius:10px;
    padding:18px;
    background:#f9fafb;
}
.card h3{
    margin:0 0 8px 0;
    font-size:16px;
}
.card p{
    font-size:13px;
    color:#444;
}
.card a{
    display:inline-block;
    margin-top:10px;
    padding:9px 14px;
    background:#2f5dff;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
    font-size:13px;
}
.card a:hover{
    background:#254bdd;
}
.footer{
    margin-top:30px;
    text-align:center;
    color:#6b7280;
    font-size:13px;
}
code{
    background:#eee;
    padding:3px 6px;
    border-radius:4px;
}
hr{
    margin:25px 0;
}
</style>
</head>

<body>

<div class="container">

<h1>📞 Sistema de Chamadas — MENU TESTE</h1>
<p>
Ambiente <strong>100% teste</strong> usando arquivo  
<code>registros_chamadas.json</code>
</p>

<hr>

<h2>🧑‍💼 ATENDIMENTO</h2>

<div class="grid">

<div class="card">
    <h3>📝 Cadastro / Atendimento</h3>
    <p>Formulário do atendente (cadastro completo da chamada).</p>
    <a href="atendente_seu_formulario_integrado.php">Acessar</a>
</div>

<div class="card">
    <h3>📋 Lista de Chamadas</h3>
    <p>Listagem geral com busca e status.</p>
    <a href="chamadas.php">Abrir</a>
</div>

<div class="card">
    <h3>🔍 Visualizar Chamada</h3>
    <p>Visualização simples da chamada.</p>
    <a href="visualizar_chamada.php?id=1">Abrir ID 1</a>
</div>

<div class="card">
    <h3>✏️ Editar Histórico</h3>
    <p>Adicionar complemento ao histórico.</p>
    <a href="editar_historico.php?id=1">Editar ID 1</a>
</div>

</div>

<hr>

<h2>🚓 DESPACHO / OPERAÇÃO</h2>

<div class="grid">

<div class="card">
    <h3>📄 Relatório da Chamada</h3>
    <p>Relatório padrão da ocorrência.</p>
    <a href="relatorio.php?id=1">Abrir ID 1</a>
</div>

<div class="card">
    <h3>🧾 Relatório Detalhado</h3>
    <p>Relatório completo com botão copiar.</p>
    <a href="relatorio_detalhe.php?id=1">Abrir ID 1</a>
</div>

<div class="card">
    <h3>🚓 Despachador</h3>
    <p>Tela de despacho com status, recurso e encerramento.</p>
    <a href="despachador.php?chamada=1">Despachar ID 1</a>
</div>

<div class="card">
    <h3>📦 Painel por Batalhão</h3>
    <p>Distribuição e controle por batalhão.</p>
    <a href="relatorio.php">Abrir Painel</a>
</div>

</div>

<hr>

<h2>🧪 TESTES / DADOS</h2>

<div class="grid">

<div class="card">
    <h3>🗂️ Ver JSON</h3>
    <p>Abrir o “banco de dados” em JSON.</p>
    <a href="registros_chamadas.json" target="_blank">Abrir JSON</a>
</div>

<div class="card">
    <h3>➕ Criar Chamada Fake</h3>
    <p>Use o formulário para gerar dados de teste.</p>
    <a href="atendente_seu_formulario_integrado.php">Criar</a>
</div>

</div>

<div class="footer">
Sistema de Chamadas • MENU DE TESTE • PHP + JSON  
<br>
(feio, simples e funciona 😎)
</div>

</div>

</body>
</html>
