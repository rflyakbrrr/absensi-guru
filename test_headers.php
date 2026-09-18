<?php

use App\Http\Controllers\Admin\AttendanceController;
use Illuminate\Http\Request;

$controller = app(AttendanceController::class);
$request = Request::create('/admin/export/daily', 'GET');
$response = $controller->exportDaily($request);

echo "Status: " . $response->getStatusCode() . "\n";
echo "Headers:\n";
foreach ($response->headers->all() as $name => $values) {
    echo $name . ": " . implode(', ', $values) . "\n";
}
