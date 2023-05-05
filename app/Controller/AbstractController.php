<?php
declare(strict_types=1);

namespace App\Controller;

abstract class AbstractController
{
    protected string $content = '';

    private string $layoutPath = __DIR__ . '/../../views/shared/layout.html';
    private string $notFoundPath = __DIR__ . '/../../views/shared/404.html';

    public function __construct()
    {
        $className = explode('\\', get_class($this));
        $className = strtolower(end($className));
        $viewPath = __DIR__ . '/../../views/';

        if (file_exists($viewPath . $className . '.html')) {
            $this->content = file_get_contents($viewPath . $className . '.html');
        } else {
            $this->content = file_get_contents($this->notFoundPath);
        }
    }

    public function addContent(string $content): void
    {
        $this->content .= $content;
    }

    public function render(): void
    {
        echo str_replace('{{content}}', $this->content, file_get_contents($this->layoutPath));
    }

    abstract public function execute(): void;
}