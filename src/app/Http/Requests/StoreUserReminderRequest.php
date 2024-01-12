<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObjects\StoreUserReminderDTO;

class StoreUserReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'      => 'required|string',
            'description'     => 'required|string',
            'remind_at'  => 'required|integer',
            'event_at'  => 'required|integer',
        ];
    }

    public function toDTO(): StoreUserReminderDTO{
        return new StoreUserReminderDTO(
            user_id: $this->user()->id,
            title: $this->title,
            description: $this->description,
            remind_at: $this->remind_at,
            event_at: $this->event_at
        );
    }
}
