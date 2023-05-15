<?php
declare(strict_types=1);

namespace App\Controller\Actions;

use App\Controller\AbstractController;
use App\Model\OpenAi;

class Image extends AbstractController
{
    /**
     * @param \App\Model\OpenAi $openAiModel
     */
    public function __construct(
        private readonly OpenAi $openAiModel = new OpenAi()
    ) {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public function handleRequest(): string
    {
        $postKeys = array_keys($_POST);

        if (in_array('submit-image-description', $postKeys, true) && empty($_POST['image-description'])) {
            throw new \Exception('Image description is empty.');
        }

        if (in_array('submit-image-description', $postKeys, true)) {
            return '<img src="data:image/png;base64,' . $this->openAiModel->generateImage($_POST['image-description'])?->data[0]?->b64_json . '"/>';
        }

        return '';
    }
}
