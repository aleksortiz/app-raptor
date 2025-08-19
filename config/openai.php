<?php

return [
    // OpenAI API Key from .env
    'api_key' => env('OPENAI_API_KEY'),

    // Base URL for the OpenAI API
    'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),

    // Default model to use for text and file reasoning
    'default_model' => env('OPENAI_MODEL', 'gpt-4.1-nano'),

    // Default timeout for requests (seconds)
    'timeout' => env('OPENAI_TIMEOUT', 120),
]; 