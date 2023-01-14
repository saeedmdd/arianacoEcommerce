<?php

namespace App\Services\SMS;

interface SMSServiceInterface
{
    public function setApiKey(string $key): void;

    public function setBaseUrl();
    public function sendMessage(string $sender, string $receptor, string $message);

}
