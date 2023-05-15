<?php
declare(strict_types=1);

namespace App\Model;

use OpenAI\Client;
use OpenAI\Responses\Audio\TranscriptionResponse;
use OpenAI\Responses\Chat\CreateResponse;
use OpenAI\Responses\Images\CreateResponse as ImagesCreateResponse;

class OpenAi
{
    private Client $openAiClient;

    public function __construct()
    {
        $this->openAiClient = \OpenAI::client(getenv('OPEN_AI_API_KEY'));
    }

    /**
     * Gets the completion from OpenAI.
     *
     * @param string $text
     *
     * @return \OpenAI\Responses\Chat\CreateResponse
     */
    public function getCompletion(string $text): CreateResponse
    {
        return $this->openAiClient->chat()->create(
            [
                'model'    => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $text],
                ],
            ]
        );
    }

    /**
     * Transcribes the audio file by OpenAI.
     *
     * @param string $filePath
     *
     * @return \OpenAI\Responses\Audio\TranscriptionResponse
     */
    public function transcribeAudio(string $filePath): TranscriptionResponse
    {
        return $this->openAiClient->audio()->transcribe(
            [
                'model'           => 'whisper-1',
                'file'            => fopen($filePath, 'r'),
                'response_format' => 'verbose_json',
            ]
        );
    }

    /**
     * Generates the image by OpenAI.
     *
     * @param string $description
     *
     * @return \OpenAI\Responses\Images\CreateResponse
     */
    public function generateImage(string $description): ImagesCreateResponse
    {
        return $this->openAiClient->images()->create(
            [
                'prompt'          => $description,
                'n'               => 1,
                'size'            => '512x512',
                'response_format' => 'b64_json',
            ]
        );
    }
}