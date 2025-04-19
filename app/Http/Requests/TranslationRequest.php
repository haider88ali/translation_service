<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="TranslationRequest",
 *     type="object",
 *     required={"key", "content", "locale"},
 *     @OA\Property(property="key", type="string"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="locale", type="string"),
 *     @OA\Property(property="tags", type="array", @OA\Items(type="string"))
 * )
 */
class TranslationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Can add authorization logic later if required
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            // Create new translation
            return [
                'key' => 'required|string|max:191|unique:translations,key',
                'locale' => 'required|string|in:en,fr,es', // Add more locales if needed
                'content' => 'required|string',
                'tags' => 'nullable|array',
                'tags.*' => 'nullable|string|exists:tags,name',
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // Update existing translation
            return [
                'key' => [
                    'required',
                    'string',
                    'max:191',
                    Rule::unique('translations', 'key')->ignore($this->route('translation')),
                ],
                'locale' => 'required|string',
                'content' => 'required|string',
                'tags' => 'nullable|array',
                'tags.*' => 'nullable|string|exists:tags,name',
            ];
        }

        // No validation for search or index/export
        return [];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'key.required' => 'Translation key is required.',
            'key.unique' => 'This translation key already exists.',
            'locale.required' => 'Locale is required.',
            'content.required' => 'Translation content is required.',
            'tags.array' => 'Tags should be an array.',
            'tags.*.exists' => 'One or more tags do not exist in the database.',
        ];
    }
}
