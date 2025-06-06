<?php

declare(strict_types=1);

namespace App\Domains\User\Http\Requests;

use App\Domains\User\Enum\UserStatus;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId' => 'required|int|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'status' => 'required|string|in:'.implode(',', [UserStatus::Vacation->value, UserStatus::Working->value]),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['userId' => $this->route('user')]);
    }

}
