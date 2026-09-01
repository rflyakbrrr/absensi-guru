<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$teacher = App\Models\Teacher::create([
    'name' => 'Guru Test Hapus',
    'position' => 'Testing',
    'status' => true,
]);

echo "Created teacher ID: " . $teacher->id . "\n";

$teacher->delete();

echo "Deleted teacher successfully!\n";
