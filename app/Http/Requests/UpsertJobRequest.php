<?php

namespace App\Http\Requests;

use App\Models\Job;
use Illuminate\Foundation\Http\FormRequest;

class UpsertJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->isMethod('POST')) {
            // For storing a new job
            return $this->user()->can('create', Job::class);
        }

        // For updating an existing job
        $job = $this->route('job'); // Assumes route model binding or a route parameter named 'job'
        return $this->user()->can('update', $job);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:job_categories,id',
            'location_id' => 'required|exists:job_locations,id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'salary_min' => 'nullable|integer|min:0',
            'salary_max' => 'nullable|integer|min:0|gte:salary_min',
            'currency' => 'required|string|max:10',
            'salary_type' => 'required|in:month,year,hour,negotiable',
            'job_type' => 'required|in:full_time,part_time,internship,freelance,remote',
            'experience_level' => 'nullable|in:junior,mid,senior,lead',
            'is_remote' => 'boolean',
            'vacancies' => 'required|integer|min:1',
            'deadline' => 'nullable|date|after:today',
            'status' => 'in:draft,published,closed',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ];
    }
}