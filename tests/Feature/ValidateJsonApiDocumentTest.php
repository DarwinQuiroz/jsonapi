<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidateJsonApiDocument;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidateJsonApiDocumentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::any('test_route', fn() => 'OK')
            ->middleware(ValidateJsonApiDocument::class);
    }

    /** @test */
    public function data_is_required()
    {
        $this->postJson('test_route', [])
        ->assertJsonApiValidationErrors('data');

        $this->patchJson('test_route', [])
        ->assertJsonApiValidationErrors('data');
    }

    /** @test */
    public function data_must_be_an_array()
    {
        $this->postJson('test_route', [
            'data' => []
        ])->assertJsonApiValidationErrors('data');

        $this->patchJson('test_route', [
            'data' => []
        ])->assertJsonApiValidationErrors('data');
    }

    /** @test */
    public function data_type_is_required()
    {
        $this->postJson('test_route', [
            'data' => [
                'attributes' => []
            ]
        ])->assertJsonApiValidationErrors('data.type');

        $this->patchJson('test_route', [
            'data' => [
                'attributes' => []
            ]
        ])->assertJsonApiValidationErrors('data.type');
    }

    /** @test */
    public function data_type_must_be_a_string()
    {
        $this->postJson('test_route', [
            'data' => [
                'type' => 1
            ]
        ])->assertJsonApiValidationErrors('data.type');

        $this->patchJson('test_route', [
            'data' => [
                'type' => 1
            ]
        ])->assertJsonApiValidationErrors('data.type');
    }
}
