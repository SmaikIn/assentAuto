<?php
declare(strict_types=1);

namespace App\Domains\Task\Http\Requests;

use App\Domains\Task\Enum\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskAssignUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'task_id' => 'required|integer|exists:tasks,id',
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
