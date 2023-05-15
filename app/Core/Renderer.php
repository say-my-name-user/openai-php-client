<?php
declare(strict_types=1);

namespace App\Core;

class Renderer
{
    protected string $content = '';

    private string $layoutPath = __DIR__ . '/../../views/shared/layout.html';
    private string $viewsPath = __DIR__ . '/../../views/actions/';

    public function __construct(string $action)
    {
        if (file_exists($this->viewsPath . $action . '.html')) {
            $this->content = file_get_contents($this->viewsPath . $action . '.html');
        }
    }

    /**
     * Adds content to the layout.
     *
     * @param string $content
     *
     * @return void
     */
    public function addContent(string $content): void
    {
        if (!empty($content)) {
            $content = '<h2 class="mt-4 text-2xl font-bold">Results:</h2>' . $content;
        }

        $this->content .= $content;
    }

    /**
     * Adds an error to the layout.
     *
     * @param string $error
     *
     * @return void
     */
    public function addError(string $error): void
    {
        $this->content .= '<div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 relative" role="alert">' . $error . '</div>';
    }

    /**
     * Renders the layout.
     *
     * @return void
     */
    public function render(): void
    {
        echo str_replace('{{content}}', $this->content, file_get_contents($this->layoutPath));
    }
}