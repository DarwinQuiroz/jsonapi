<?php

namespace Tests;
use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\ExpectationFailedException;

trait MakesJsonApiRequests
{
    protected function setUp(): void
    {
        parent::setUp();

        TestResponse::macro('assertJsonApiValidationErrors', $this->assertJsonApiValidationErrors());
    }

    public function assertJsonApiValidationErrors()
    {
        return function($attribute) {
            /** @var TestResponse $this */

            try
            {
                $this->assertJsonFragment([
                    'source' => ['pointer' => '/data/attributes/'.$attribute]
                ]);
            }
            catch(ExpectationFailedException $e)
            {
                PHPUnit::fail("Failes to find a JSON:API validation error for key: '{$attribute}'" .PHP_EOL.PHP_EOL . $e->getMessage());
            }

            try
            {
                $this->assertJsonStructure([
                    'errors' => [
                        [
                            'title', 'detail', 'source' => ['pointer']
                        ]
                    ]
                ]);
            }
            catch(ExpectationFailedException $e)
            {
                PHPUnit::fail("Failes to find a valid JSON:API error response" .PHP_EOL.PHP_EOL . $e->getMessage());
            }

            $this->assertStatus(422)
                ->assertHeader('content-type', 'application/vnd.api+json');
        };
    }

    public function json($method, $uri, array $data = [], array $headers = []): TestResponse
    {
        $headers['accept'] = 'application/vnd.api+json';

        return parent::json($method, $uri, $data, $headers);
    }

    public function postJson($uri, array $data = [], array $headers = []): TestResponse
    {
        $headers['content-type'] = 'application/vnd.api+json';

        return parent::postJson($uri, $data, $headers);
    }

    public function patchJson($uri, array $data = [], array $headers = []): TestResponse
    {
        $headers['content-type'] = 'application/vnd.api+json';

        return parent::patchJson($uri, $data, $headers);
    }
}
