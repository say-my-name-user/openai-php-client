<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    /**
     * Defines the controller to be used.
     *
     * @return string
     */
    public function getController(): string
    {
        $currentUrl = $_SERVER['PATH_INFO'] ?? '';
        $currentUrl = explode('/', $currentUrl);
        $currentUrl = ucfirst(end($currentUrl));

        if (empty($currentUrl)) {
            $currentUrl = 'Index';
        }

        $controller = 'App\\Controller\\Actions\\' . $currentUrl;

        if (!class_exists($controller)) {
            $controller = 'App\\Controller\\NotFound';
        }

        return $controller;
    }
}