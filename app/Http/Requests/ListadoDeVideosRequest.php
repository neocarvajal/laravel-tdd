<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListadoDeVideosRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'limit' => 'integer|max:50|min:1',
            'page' => 'integer|min:1',
        ];
    }

    public function getLimit(): int
    {
        return $this->get('limit', 30);
    }

    public function getPage(): int
    {
        return $this->get('page', 1);
    }
}