<?php

namespace App\Services;

use App\Models\Translation;
use App\Repositories\TranslationRepository;

class TranslationService
{
    // The repository instance that handles the data operations
    protected TranslationRepository $repository;

    // Constructor to inject the TranslationRepository into the service
    public function __construct(TranslationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * List all translations.
     *
     * This method retrieves all translations from the repository.
     * It returns a collection of translations.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return $this->repository->getAll();
    }

    /**
     * Create a new translation.
     *
     * This method creates a new translation using the provided data.
     * If tags are provided, it syncs the tags with the newly created translation.
     * It returns the newly created translation with its tags loaded.
     *
     * @param array $data
     * @return \App\Models\Translation
     */
    public function create(array $data)
    {
        $translation = $this->repository->create($data);

        if (!empty($data['tags'])) {
            $this->repository->syncTags($translation, $data['tags']);
        }

        return $translation->load('tags');
    }

    /**
     * Update an existing translation.
     *
     * This method updates an existing translation identified by its ID.
     * If tags are provided in the data, it syncs the tags with the updated translation.
     * It returns the updated translation with its tags loaded.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Translation
     */
    public function update($id, array $data)
    {
        $translation = $this->repository->find($id);
        $updated = $this->repository->update($translation, $data);

        if (!empty($data['tags'])) {
            $this->repository->syncTags($updated, $data['tags']);
        }

        return $updated->load('tags');
    }

    /**
     * Show a single translation by ID.
     *
     * This method retrieves a translation by its ID.
     * It returns the translation instance.
     *
     * @param int $id
     * @return \App\Models\Translation
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Export translations for a specific locale.
     *
     * This method retrieves all translations for a given locale.
     * It returns the translations in a format suitable for export.
     *
     * @param string $locale
     * @return \Illuminate\Support\Collection
     */
    public function export($locale)
    {
        return $this->repository->getTranslationsByLocale($locale);
    }

    /**
     * Search translations based on provided filters.
     *
     * This method performs a search for translations using the given filters.
     * It returns a collection of translations that match the search criteria.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($filters)
    {
        return $this->repository->search($filters);
    }
}
