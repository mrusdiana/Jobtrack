<?php
require_once __DIR__ . "/config/database.php";
echo "Koneksi berhasil. Tabel: ";
print_r($pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN));