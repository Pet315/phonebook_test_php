<?php
namespace App\Core;

class View {
    public function render(string $template, array $params=[]): void {
        extract($params);
        $templatePath = __DIR__ . '/../../views/' . $template . '.php';
        require __DIR__ . '/../../views/layouts/header.php';
        require $templatePath;
        require __DIR__ . '/../../views/layouts/footer.php';
    }
}
