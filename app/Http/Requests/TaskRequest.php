<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'task_status_id' => ['required', 'exists:task_statuses'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
