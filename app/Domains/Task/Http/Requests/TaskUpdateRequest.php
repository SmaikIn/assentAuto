<?php

declare(strict_types=1);

namespace App\Domains\Task\Http\Requests;

use App\Domains\Task\Enum\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'taskId' => 'required|int|exists:tasks,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'taskStatus' => 'required|string|in:'.implode(',',
                    [TaskStatus::Waiting->value, TaskStatus::Pending->value, TaskStatus::Success]),
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
