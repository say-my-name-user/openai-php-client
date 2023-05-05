<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();

ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');

$instance = new App\Controller\Index();
$instance->execute();
