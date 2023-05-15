<?php
declare(strict_types=1);

namespace App\Controller;

class NotFound extends AbstractController
{
    private string $templatePath = __DIR__ . '/../../views/shared/404.html';

    /**
     * @inheritdoc
     */
    public function handleRequest(): string
    {
        return file_get_contents($this->templatePath);
    }
}
