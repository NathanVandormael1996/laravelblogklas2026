<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Input normaliseren vóór validatie.
     */
    protected function prepareForValidation(): void
    {
        $title = trim((string) $this->input('title', ''));
        $slug = trim((string) $this->input('slug', ''));
        $isPublished = $this->boolean('is_published');
        $isFeatured = $this->boolean('is_featured');
        $publishedAt = $this->input('published_at');

        $this->merge([
            'title' => $title,
            'slug' => $slug !== '' ? Str::slug($slug) : Str::slug($title),
            'is_published' => $isPublished,
            'is_featured' => $isFeatured,
            'categories' => $this->input('categories', []),
            'published_at' => $isPublished
                ? ($publishedAt ?: now())
                : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'slug' => ['required', 'string', 'min:3', 'max:255', Rule::unique('posts', 'slug')],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'body' => ['required', 'string', 'min:10'],

            'is_published' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],

            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', Rule::exists('categories', 'id')],

            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
