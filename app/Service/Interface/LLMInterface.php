<?php

namespace App\Service\Interface;

interface LLMInterface
{
    public function generateResponse($data): void;
}