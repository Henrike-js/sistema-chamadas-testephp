<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Sistema de Chamadas – Teste</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f3f4f6;
}
.container{
    max-width:900px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}
h1{
    margin-top:0;
    color:#16325C;
}
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:20px;
}
.card{
    border:1px solid #e5e7eb;
    border-radius:10px;
    padding:20px;
    text-align:center;
    background:#f9fafb;
}
.card h3{
    margin-top:0;
}
.card a{
    display:inline-block;
    margin-top:10px;
    padding:10px 16px;
    background:#2f5dff;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
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
</style>
</head>

<body>

<div class="container">

<h1>📞 Sistema de Chamadas</h1>
<p>Ambiente de <strong>teste</strong> utilizando arquivo <code>registros_chamadas.json</code></p>

<div class="grid">

    
 <div class="card">
        <h3>📋 atendente seu formulario integrado</h3>
        <p>atendente seu formulario integrados.</p>
        <a href="atendente_seu_formulario_integrado.php">Acessar</a>
    </div>
<div class="card">
        <h3>📋 Listar Chamadas</h3>
        <p>Consulta geral das chamadas registradas.</p>
        <a href="lista_chamadas.php">Acessar</a>
    </div>

    <div class="card">
        <h3>🔍 Visualizar Chamada</h3>
        <p>Abrir uma chamada específica (exemplo).</p>
        <a href="visualizar_chamada.php?id=1">Abrir ID 1</a>
    </div>

    <div class="card">
        <h3>✏️ Editar Histórico</h3>
        <p>Adicionar complemento ao histórico.</p>
        <a href="editar_historico.php?id=1">Editar ID 1</a>
    </div>

    <div class="card">
        <h3>🧪 Testar JSON</h3>
        <p>Verificar se o arquivo JSON está acessível.</p>
        <a href="registros_chamadas.json" target="_blank">Abrir JSON</a>
    </div>

</div>

<div class="footer">
    Ambiente de teste — Sistema de Chamadas (JSON)
</div>

</div>

</body>
</html>
