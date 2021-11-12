<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConnectPeopleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'relations' => ['required', 'array', 'min:1'],
            'relations.*.relative_id' => ['required', 'exists:people,id'],
            'relations.*.relationship' => ['required', 'string', Rule::in(['sibling', 'spouse', 'father', 'mother'])],
        ];
    }
}
