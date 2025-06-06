<?php

declare(strict_types=1);

namespace App\Domains\Task\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'taskId' => 'required|int|exists:tasks,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['taskId' => $this->route('task')]);
    }

}
