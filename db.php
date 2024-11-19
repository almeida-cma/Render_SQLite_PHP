<?php
// Conectar ao banco de dados SQLite
$db = new SQLite3('usuarios.db');

// Criar a tabela se não existir
$query = "CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL)";
$db->exec($query);
?>
