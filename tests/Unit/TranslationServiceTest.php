<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Translation;
use App\Models\Tag;
use App\Services\TranslationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_translation_with_tags()
    {
        // Create tag(s) first
        Tag::factory()->create(['name' => 'web']);

        // Call the service
        $service = app(TranslationService::class);
        $data = [
            'key' => 'home.title',
            'locale' => 'en',
            'content' => 'Home Page',
            'tags' => ['web']
        ];

        $translation = $service->create($data);

        // Assertions
        $this->assertInstanceOf(Translation::class, $translation);
        $this->assertEquals('home.title', $translation->key);
        $this->assertTrue($translation->tags->contains('name', 'web'));
    }
}
