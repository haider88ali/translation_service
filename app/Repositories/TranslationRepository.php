<?php

namespace App\Repositories;

use App\Models\Translation;
use App\Models\Tag;

class TranslationRepository
{
    /**
     * Get all translations along with their associated tags.
     *
     * This method retrieves all translations from the database, along with their associated tags.
     * It returns a collection of all translations.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        // Retrieve all translations with their related tags
        return Translation::with('tags')->get();
    }

    /**
     * Find a translation by its ID.
     *
     * This method retrieves a specific translation and its tags by the given ID.
     * It returns a translation instance.
     *
     * @param int $id
     * @return \App\Models\Translation
     */
    public function find($id)
    {
        // Find and return the translation with its tags by ID
        return Translation::with('tags')->findOrFail($id);
    }

    /**
     * Create a new translation.
     *
     * This method inserts a new translation record into the database using the provided data.
     * It returns the created translation instance.
     *
     * @param array $data
     * @return \App\Models\Translation
     */
    public function create(array $data)
    {
        // Create and return the new translation using the provided data
        return Translation::create($data);
    }

    /**
     * Update an existing translation.
     *
     * This method updates the given translation record with the new data.
     * It returns the updated translation instance.
     *
     * @param \App\Models\Translation $translation
     * @param array $data
     * @return \App\Models\Translation
     */
    public function update(Translation $translation, array $data)
    {
        // Update the translation and return the updated translation
        $translation->update($data);
        return $translation;
    }

    /**
     * Sync the tags for a given translation.
     *
     * This method associates tags with a translation based on the tag names provided.
     * It synchronizes the tags in the database.
     *
     * @param \App\Models\Translation $translation
     * @param array $tagNames
     * @return void
     */
    public function syncTags(Translation $translation, array $tagNames)
    {
        // Retrieve tag IDs from the tag names and sync them with the translation
        $tagIds = Tag::whereIn('name', $tagNames)->pluck('id');
        $translation->tags()->sync($tagIds);
    }

    /**
     * Get translations by a specific locale.
     *
     * This method retrieves all translations for a given locale. The content of each translation is
     * returned, keyed by the translation's key.
     *
     * @param string $locale
     * @return \Illuminate\Support\Collection
     */
    public function getTranslationsByLocale($locale)
    {
        // Retrieve and return translations for the specific locale
        return Translation::where('locale', $locale)->pluck('content', 'key');
    }

    /**
     * Search translations based on filters.
     *
     * This method allows filtering translations by tag, key, or content. It dynamically builds a query
     * based on the provided filters and returns the matching translations.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($filters)
    {
        $query = Translation::query();

        // Filter by tag if provided
        if (!empty($filters['tag'])) {
            $query->whereHas('tags', fn($q) => $q->where('name', $filters['tag']));
        }

        // Filter by translation key if provided
        if (!empty($filters['key'])) {
            $query->where('key', 'like', "%{$filters['key']}%");
        }

        // Filter by content if provided
        if (!empty($filters['content'])) {
            $query->where('content', 'like', "%{$filters['content']}%");
        }

        // Return the filtered translations with their tags
        return $query->with('tags')->get();
    }
}
