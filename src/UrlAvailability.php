<?php

namespace Ratiborro\UrlAvailability;

use GuzzleHttp\Client;

class UrlAvailability
{
    protected $urls = [];
    protected $availableUrls = [];
    protected $unavailableUrls = [];
    protected $checked = false;
    protected $url;
    protected $statusCode;
    protected $errors;

    protected $httpClient;

    public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->httpClient = Client::class;
    }

    protected function checkUrl(): bool
    {
        try {
            $this->getStatusCode();
        } catch (\Exception $e) {
            $this->setUnavailableStatusCode();
        }
        return $this->urlIsAvailable();
    }

    protected function getStatusCode(): int
    {
        $httpResponse = $this->httpClient->options($this->url);
        return $this->statusCode = $httpResponse->getStatusCode();
    }

    protected function urlIsAvailable(): bool
    {
        return $this->statusCode === 200;
    }

    protected function setUnavailableStatusCode(): void
    {
        $this->statusCode = 500;
    }

    public function checkUrls(): array
    {
        if (!$this->checked) {
            foreach ($this->urls as $this->url) {
                $this->checkUrl();
                if ($this->urlIsAvailable()) {
                    $this->availableUrls[] = $this->url;
                } else {
                    $this->unavailableUrls[] = $this->url;
                    $this->errors[$this->url] = [
                        'status' => $this->statusCode
                    ];
                }
            }
        }

        return [
            'all' => $this->urls,
            'available' => $this->availableUrls,
            'unavailable' => $this->unavailableUrls,
        ];
    }

    public function all(): array
    {
        return $this->urls;
    }

    public function availableUrls(): array
    {
        return $this->availableUrls;
    }

    public function unavailableUrls(): array
    {
        return $this->unavailableUrls;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}