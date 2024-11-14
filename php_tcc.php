<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "sistema_login";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Capturar os dados do formulário
$nomeCompleto = $_POST['nome_completo'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmarSenha = $_POST['confirmar_senha'];

// Validar se as senhas coincidem
if ($senha !== $confirmarSenha) {
    echo "As senhas não coincidem.";
    exit();
}

// Criptografar a senha
$senhaCriptografada = password_hash($senha, PASSWORD_BCRYPT);

// Inserir dados no banco de dados
$sql = "INSERT INTO usuarios (nome_completo, email, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nomeCompleto, $email, $senhaCriptografada);

if ($stmt->execute()) {
    echo "Conta criada com sucesso!";
} else {
    echo "Erro ao criar conta: " . $conn->error;
}

// Fechar conexão
$stmt->close();
$conn->close();
?>
