<?php
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\User::firstOrNew(['email' => 'siswa_les@abdipraja.id']);
$user->nama = 'Siswa Audit Test';
$user->password = bcrypt('siswa123');
$user->status = 'S';
$user->save();

echo "User created/updated: ID {$user->id}, Email: {$user->email}\n";
