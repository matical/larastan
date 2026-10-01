<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListElementRulesRequest extends FormRequest
{
    /** @return array<string, string> */
    public function rules(): array
    {
        return [
            'scalars' => 'required|list',
            'scalars.*' => 'string',
            'arrays' => 'required|list',
            'arrays.*' => 'array',
            'any' => 'required|list',
            'any.*' => 'nullable',
            'rows' => 'required|list',
            'rows.*.id' => 'required|integer',
            'options' => 'required|array:theme,locale',
            'options.*' => 'string',
            'flags' => 'required|array|array:beta',
            'flags.*' => 'accepted',
        ];
    }
}
