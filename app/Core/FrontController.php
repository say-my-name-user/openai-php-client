<?php
declare(strict_types=1);

namespace App\Core;

class FrontController
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Finds the controller and executes it.
     *
     * @return string
     */
    public function execute(): string
    {
        $controller = $this->router->getController();
        $controller = new $controller();

        return $controller->execute();
    }
}