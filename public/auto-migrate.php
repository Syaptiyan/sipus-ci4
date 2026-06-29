<?php
// Auto migrate script - delete this file after use
define('FCPATH', __DIR__);
chdir(FCPATH);

// Load framework
require FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();

require rtrim($paths->systemDirectory, '\\/ ') . '/bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();
$app->setContext('cli');

// Run migrations
$migrate = service('migrations');
$migrate->latest();

echo "✅ Migration complete!\n";

// Run seeder
$seeder = \Config\Database::seeder();
$seeder->call('DatabaseSeeder');

echo "✅ Seeder complete!\n";
echo "🎉 Database ready!\n";
