<?php
use League\Plates\Engine;
use League\Plates\Extension\Asset;
use Psr\Container\ContainerInterface;

$database = require 'config/database.php';

return [
    'view_path' => 'src/View',
    'asset_path' => 'public/assets',
    Engine::class => function(ContainerInterface $c) {
        return new Engine($c->get('view_path'));
    },
    Asset::class => function(ContainerInterface $c) {
        return new Asset('public/assets', false);
    },
    PDO::class => function(ContainerInterface $c) use ($database) {
        return new PDO(
            $database['dsn'],
            $database['username'],
            $database['password']
        );
    }
];
