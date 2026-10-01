<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** @property mixed $documented */
class DeclaredPropertiesRequest extends FormRequest
{
    public mixed $nativeName;

    /** @return array<string, string> */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'nickname' => 'string',
            'documented' => 'required|string',
            'nativeName' => 'required|string',
        ];
    }
}
