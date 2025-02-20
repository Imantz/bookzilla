<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookFilterRequest extends FormRequest
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
            'q'          => 'nullable|string|max:255',
            'sort_by'    => 'nullable|in:title,total_purchases,purchases',
            'sort_order' => 'nullable|in:asc,desc',
            'limit'      => 'nullable|integer|min:1|max:100',
        ];
    }

   /**
     * Handle the validation and set default values after validation.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            
            $today = now()->format('Y-m-d');
            $oneMonthAgo = now()->subMonth()->format('Y-m-d');
    
            // Check if date_from is missing or invalid, then set it to one month ago
            if (!$this->filled('date_from') || \DateTime::createFromFormat('Y-m-d', $this->input('date_from')) === false) {
                $this->merge([
                    'date_from' => $oneMonthAgo, // Default to one month ago
                ]);
            }
    
            // Check if date_to is missing or invalid, then set it to today's date
            if (!$this->filled('date_to') || \DateTime::createFromFormat('Y-m-d', $this->input('date_to')) === false) {
                $this->merge([
                    'date_to' => $today, // Default to today's date
                ]);
            }
        });
    }    

    public function filters()
    {
        return $this->only(['q', 'sort_by', 'sort_order', 'date_from', 'date_to', 'limit']);
    }
}
