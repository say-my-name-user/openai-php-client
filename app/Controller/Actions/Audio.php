<?php
declare(strict_types=1);

namespace App\Controller\Actions;

use App\Controller\AbstractController;
use App\Model\OpenAi;

class Audio extends AbstractController
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

        if (in_array('submit-audio', $postKeys, true) && empty($_FILES['audio']['name'])) {
            throw new \Exception('Audio file is not uploaded.');
        }

        if (in_array('submit-audio', $postKeys, true)) {
            return $this->openAiModel->transcribeAudio($this->uploadFile())->toArray()['text'] ?? '';
        }

        return '';
    }

    /**
     * Uploads the file to the server.
     *
     * @return bool|string
     * @throws \Exception
     */
    private function uploadFile(): bool|string
    {
        $uploadDir = __DIR__ . '/../../uploads/';
        $uploadedFile = $uploadDir . basename($_FILES['audio']['name']);

        if (!is_uploaded_file($_FILES['audio']['tmp_name']) || !move_uploaded_file($_FILES['audio']['tmp_name'], $uploadedFile)) {
            throw new \Exception('File upload failed.');
        }

        return $uploadedFile;
    }
}
