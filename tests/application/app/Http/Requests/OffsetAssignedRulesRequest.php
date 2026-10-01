<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffsetAssignedRulesRequest extends FormRequest
{
    /** @return array<string, string> */
    public function rules(): array
    {
        $rules          = ['value' => 'required|string'];
        $rules['value'] = 'required|integer';

        return $rules;
    }
}
