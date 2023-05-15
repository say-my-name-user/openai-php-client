<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Renderer;

abstract class AbstractController
{
    private Renderer $renderer;

    public function __construct()
    {
        $className = explode('\\', get_class($this));
        $className = strtolower(end($className));

        $this->renderer = new Renderer($className);
    }

    /**
     * Executes the controller action.
     *
     * @return void
     */
    public function execute(): void
    {
        try {
            $this->renderer->addContent($this->handleRequest());
        } catch (\Throwable $e) {
            $this->renderer->addError($e->getMessage());
        } finally {
            $this->renderer->render();
        }
    }

    /**
     * Handles the request.
     *
     * @return string
     * @throws \Exception
     */
    abstract public function handleRequest(): string;
}