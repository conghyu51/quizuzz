<?php

namespace App\Controllers;

use Exception;

abstract class BaseController
{
    protected function render(string $pageName, array $data = [])
    {
        extract($data);

        ob_start();
        if (!file_exists($pagePath = BASE . "/views/pages/$pageName.php")) {
            throw new Exception("View file not found: $pagePath");
        }

        include $pagePath;
        $slot = ob_get_clean();

        $layout = $data['layout'] ?? 'app';
        include BASE . "/views/layouts/$layout.php";
    }

    protected function responseJson(array $data): never
    {
        header('Content-Type: application/json');
        echo json_encode($data);

        exit;
    }
}
