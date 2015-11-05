<?php

// CREATE TABLE hearts (deviceId TINYTEXT NOT NULL, presentatieId int NOT NULL, CONSTRAINT c_pairs UNIQUE (presentatieId, deviceId));

// DELETE FROM hearts;

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["deviceId"] && $_POST["presentatieId"]) {
    $deviceId = $_POST["deviceId"];
    $presentatieId = (int) $_POST["presentatieId"];
    if (isset($_POST["hearted"]) && $_POST["hearted"] === "true") {
        $sql = "INSERT OR IGNORE INTO hearts (deviceId, presentatieId) VALUES ('{$deviceId}', {$presentatieId});";
    } else {
        $sql = "DELETE FROM hearts WHERE deviceId = '{$deviceId}' AND presentatieId = {$presentatieId};";
    }
    $pdo = new PDO('sqlite:db/hearts.db');
    $rs = $pdo->query($sql);
}

$sql = "SELECT presentatieId, COUNT(*) as count FROM hearts GROUP BY presentatieId;";
$pdo = new PDO('sqlite:db/hearts.db');
$rs = $pdo->query($sql);
header("Content-type: application/json");
echo json_encode($rs->fetchAll(PDO::FETCH_ASSOC));
