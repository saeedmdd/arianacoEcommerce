<?php

namespace App\Services\SMS\Kavenegar;
use App\Services\SMS\SMSServiceInterface;
use Illuminate\Support\Facades\Log;

class Kavenegar implements SMSServiceInterface
{
    public function __construct()
    {
        $this->setBaseUrl();
        $this->setApiKey(config("sms.kavenegar.key"));
    }

    protected string $key;
    protected string $url;
    public function setApiKey(string $key): void
    {
        $this->key = $key;
    }

    public function setBaseUrl()
    {
        $this->url = "https://example.com";
    }

    public function sendMessage(string $sender, string $receptor, string $message)
    {
        Log::info("this message is sent to $receptor with $message by $sender by ".self::class);
    }
}
