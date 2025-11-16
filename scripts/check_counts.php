<?php
$autoload = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoload)) {
	echo "vendor/autoload.php not found. Run composer install.\n";
	exit(1);
}
require $autoload;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cultural;
use App\Models\CulturalGallery;
use App\Models\CulturalGeodata;
use App\Models\User;

echo "Culturals: " . Cultural::count() . PHP_EOL;
echo "Galleries: " . CulturalGallery::count() . PHP_EOL;
echo "Geodata: " . CulturalGeodata::count() . PHP_EOL;
echo "Users: " . User::count() . PHP_EOL;
