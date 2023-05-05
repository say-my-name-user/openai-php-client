<?php
declare(strict_types=1);

namespace App\Controller;


use App\Model\OpenAi;

class Index extends AbstractController
{
    /**
     * @param \App\Model\OpenAi $openAiModel
     */
    public function __construct(
        private OpenAi $openAiModel = new OpenAi()
    ) {
        parent::__construct();
    }

    /**
     * Executes the controller action.
     *
     * @return void
     */
    public function execute(): void
    {
        try {
            $this->addContent($this->prepareResponse());
        } catch (\Throwable $e) {
            $this->addContent($e->getMessage());
        } finally {
            $this->render();
        }
    }

    /**
     * Prepares the response.
     *
     * @return string
     */
    private function prepareResponse(): string
    {
        $response = '<h2>Results:</h2>';
        $postKeys = array_keys($_POST);

        if (in_array('submit-text', $postKeys, true) && empty($_POST['text'])) {
            $response .= 'Text is empty.';
            return $response;
        }

        if (in_array('submit-audio', $postKeys, true) && empty($_FILES['audio']['name'])) {
            $response .= 'Audio file is not uploaded.';
            return $response;
        }

        if (in_array('submit-text', $postKeys, true)) {
            $response .= '<pre>' . var_export(
                    $this->openAiModel->getCompletion($_POST['text'])->toArray()['choices'][0]['message']['content'] ?? '',
                    true
                ) . '</pre>';
            return $response;
        }

        if (in_array('submit-audio', $postKeys, true)) {
            $response .= '<pre>' . var_export(
                    $this->openAiModel->transcribeAudio($this->uploadFile())->toArray()['text'] ?? '',
                    true
                ) . '</pre>';
            return $response;
        }

        return $response;
    }

    /**
     * Uploads the file to the server.
     *
     * @return bool|string
     */
    private function uploadFile(): bool|string
    {
        $uploadDir = __DIR__ . '/../../uploads/';
        $uploadedFile = $uploadDir . basename($_FILES['audio']['name']);

        if (!is_uploaded_file($_FILES['audio']['tmp_name']) || !move_uploaded_file($_FILES['audio']['tmp_name'], $uploadedFile)) {
            $this->addContent('File upload failed.');

            return false;
        }

        $this->addContent('File uploaded successfully.');

        return $uploadedFile;
    }
}