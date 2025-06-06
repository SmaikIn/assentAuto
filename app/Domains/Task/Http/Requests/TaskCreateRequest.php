<?php
declare(strict_types=1);

namespace App\Domains\Task\Http\Requests;

use App\Domains\Task\Enum\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'taskStatus' => 'required|string|in:'.implode(',',
                    [TaskStatus::Waiting->value, TaskStatus::Pending->value, TaskStatus::Success]),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
