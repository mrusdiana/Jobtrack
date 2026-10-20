<?php

require_once __DIR__ . "/config/database.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = $_POST["id"] ?? null;

$id = filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" >= 1]]);

if ($id !== false) {

    $sql = "DELETE FROM applications
            WHERE id = :id ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(["id" => $id]);
}

header("Location: index.php?deleted=1");
exit;

?>