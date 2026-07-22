<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$tables = ['users','roles','students','payments','settings','subjects','schedules','attendances','teacher_attendances','exam_questions','exam_attempts','exam_payments','nilais','notifikasis','pengumuman','pembayaran_konfirmasis','ujians'];
foreach ($tables as $table) {
    try {
        $count = $pdo->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
        echo $table . ':' . $count . PHP_EOL;
    } catch (Exception $e) {
        echo $table . ':ERR ' . $e->getMessage() . PHP_EOL;
    }
}
