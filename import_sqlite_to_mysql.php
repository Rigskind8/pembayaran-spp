<?php
$sourcePath = __DIR__ . '/database/database.sqlite';
$targetDsn = 'mysql:host=127.0.0.1;port=3306;dbname=pembayaran_spp;charset=utf8mb4';
$targetUser = 'root';
$targetPass = 'iki';

$source = new PDO('sqlite:' . $sourcePath);
$source->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$target = new PDO($targetDsn, $targetUser, $targetPass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$target->exec('SET FOREIGN_KEY_CHECKS = 0');

$tables = [
    'users', 'roles', 'students', 'payments', 'payment_methods', 'settings', 'subjects',
    'schedules', 'attendances', 'teacher_attendances', 'exam_questions', 'exam_attempts',
    'exam_payments', 'nilais', 'notifikasis', 'pengumuman', 'pembayaran_konfirmasis', 'ujians'
];

foreach ($tables as $table) {
    try {
        $sourceTable = $source->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$table'")->fetchColumn();
        if (!$sourceTable) {
            echo "Skip $table (source missing)\n";
            continue;
        }

        $targetExists = $target->query("SHOW TABLES LIKE '$table'")->fetchColumn();
        if (!$targetExists) {
            echo "Skip $table (target missing)\n";
            continue;
        }

        $target->exec("TRUNCATE TABLE `$table`");

        $sourceCols = $source->query("PRAGMA table_info('$table')")->fetchAll(PDO::FETCH_ASSOC);
        $sourceCols = array_map(fn($col) => $col['name'], $sourceCols);

        $targetCols = [];
        foreach ($target->query("SHOW COLUMNS FROM `$table`") as $col) {
            $targetCols[] = $col['Field'];
        }

        $sharedCols = array_values(array_intersect($sourceCols, $targetCols));
        if (empty($sharedCols)) {
            echo "Skip $table (no shared columns)\n";
            continue;
        }

        $rows = $source->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
        $count = count($rows);
        echo "Importing $table ($count rows)\n";

        if ($count === 0) {
            continue;
        }

        $colsList = implode('`, `', $sharedCols);
        $placeholders = implode(', ', array_fill(0, count($sharedCols), '?'));
        $stmt = $target->prepare("INSERT INTO `$table` (`$colsList`) VALUES ($placeholders)");

        foreach ($rows as $row) {
            $values = [];
            foreach ($sharedCols as $col) {
                $value = $row[$col] ?? null;
                if ($value === '') {
                    $value = null;
                }
                $values[] = $value;
            }
            $stmt->execute($values);
        }
    } catch (Exception $e) {
        echo "Failed for $table: " . $e->getMessage() . "\n";
    }
}

$target->exec('SET FOREIGN_KEY_CHECKS = 1');
echo "Finished import.\n";
