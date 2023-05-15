<?php
declare(strict_types=1);

namespace App\Controller\Actions;

use App\Controller\AbstractController;
use App\Model\OpenAi;

class Completion extends AbstractController
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

        if (in_array('submit-text', $postKeys, true) && empty($_POST['text'])) {
            throw new \Exception('Text is empty.');
        }

        if (in_array('submit-text', $postKeys, true)) {
            return $this->openAiModel->getCompletion($_POST['text'])->toArray()['choices'][0]['message']['content'] ?? '';
        }

        return '';
    }
}
