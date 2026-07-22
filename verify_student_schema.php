<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$connection = app('db')->connection();
$schema = $connection->getSchemaBuilder();

$columnType = $schema->getColumnType('students', 'class_id');
$exists = $schema->hasColumn('students', 'class_id');

$student = new App\Models\Student();
$student->name = 'Verify Student';
$student->nis = 'NIS-VERIFY-001';
$student->class_id = 'XII-IPA';
$student->email = 'verify.student@example.com';
$student->save();

$result = json_encode([
    'column_exists' => $exists,
    'column_type' => $columnType,
    'saved_id' => $student->id,
    'saved_class_id' => $student->fresh()->class_id,
], JSON_PRETTY_PRINT);

file_put_contents('verify_student_schema.log', $result . PHP_EOL);