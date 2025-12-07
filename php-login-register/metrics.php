<?php

require 'vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

$registry = new CollectorRegistry(new InMemory());

$counter = $registry->getOrRegisterCounter(
    'app',
    'http_requests_total',
    'Total HTTP Requests',
    ['method']
);

$method = $_SERVER['REQUEST_METHOD'] ?? 'CLI';
$counter->inc([$method]);

$renderer = new RenderTextFormat();
$result = $renderer->render($registry->getMetricFamilySamples());

header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
echo $result;
