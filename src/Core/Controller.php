<?php
namespace App\Core;

class Controller
{
    protected $config;
    public function __construct(array $config){ $this->config = $config; }

    protected function view(string $template, array $params=[]): void {
        (new View())->render($template, $params);
    }
    protected function json(array $payload, int $code=200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($payload);
    }
}
