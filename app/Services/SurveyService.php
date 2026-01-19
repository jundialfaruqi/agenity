<?php

namespace App\Services;

use App\Models\Survey;
use App\Models\SurveyToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class SurveyService
{
    public function listSurveys(?string $query = null, ?string $visibility = null, int $perPage = 10): LengthAwarePaginator
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $builder = Survey::with(['opd', 'creator', 'tokens'])->latest();

        if ($user->hasRole('admin-opd')) {
            $builder->where(function ($q) use ($user) {
                $q->where('created_by', $user->id)
                    ->orWhere('opd_id', $user->opd_master_id);
            });
        }

        if ($query) {
            $builder->where('title', 'like', "%{$query}%");
        }

        if ($visibility) {
            $builder->where('visibility', $visibility);
        }

        return $builder->paginate($perPage)->withQueryString();
    }

    public function createSurvey(array $data): Survey
    {
        $survey = Survey::create($data);

        if ($survey->visibility === 'private') {
            $this->generateToken($survey);
        }

        return $survey;
    }

    public function updateSurvey(Survey $survey, array $data): bool
    {
        $updated = $survey->update($data);

        if ($updated && $survey->visibility === 'private' && $survey->tokens()->count() === 0) {
            $this->generateToken($survey);
        }

        return $updated;
    }

    public function generateToken(Survey $survey): SurveyToken
    {
        return $survey->tokens()->create([
            'token' => Str::uuid(),
            'is_used' => false,
        ]);
    }

    public function deleteSurvey(Survey $survey): bool
    {
        return $survey->delete();
    }

    public function addQuestion(Survey $survey, array $data): \App\Models\SurveyQuestion
    {
        $question = $survey->questions()->create([
            'question_text' => $data['question_text'],
            'type' => $data['type'],
            'is_required' => isset($data['is_required']),
            'order' => $survey->questions()->count() + 1,
        ]);

        if (isset($data['options']) && in_array($data['type'], ['single_choice', 'multiple_choice'])) {
            foreach ($data['options'] as $optionText) {
                if (!empty($optionText)) {
                    $question->options()->create(['option_text' => $optionText]);
                }
            }
        }

        return $question;
    }

    public function deleteQuestion(\App\Models\SurveyQuestion $question): bool
    {
        return $question->delete();
    }

    public function getSurveyResults(Survey $survey): array
    {
        $results = [];
        $survey->load(['questions.options', 'questions.answers.option']);

        foreach ($survey->questions as $question) {
            $totalQuestionRespondents = $question->answers->unique('respondent_id')->count();

            $questionResult = [
                'id' => $question->id,
                'text' => $question->question_text,
                'type' => $question->type,
                'total_responses' => $totalQuestionRespondents,
                'data' => []
            ];

            if (in_array($question->type, ['single_choice', 'multiple_choice'])) {
                foreach ($question->options as $option) {
                    $count = $question->answers->where('option_id', $option->id)->count();
                    $questionResult['data'][] = [
                        'label' => $option->option_text,
                        'count' => $count,
                        'percentage' => $totalQuestionRespondents > 0
                            ? round(($count / $totalQuestionRespondents) * 100, 1)
                            : 0
                    ];
                }
            } elseif ($question->type === 'rating') {
                for ($i = 1; $i <= 5; $i++) {
                    $count = $question->answers->where('answer_text', (string)$i)->count();
                    $questionResult['data'][] = [
                        'label' => $i . ' Bintang',
                        'count' => $count,
                        'percentage' => $questionResult['total_responses'] > 0
                            ? round(($count / $questionResult['total_responses']) * 100, 1)
                            : 0
                    ];
                }
                $average = $question->answers->avg('answer_text');
                $questionResult['average_rating'] = round($average, 1);
            } else {
                // Text answers
                $questionResult['data'] = $question->answers->pluck('answer_text')->filter()->take(10)->toArray();
            }

            $results[] = $questionResult;
        }

        return $results;
    }

    public function getStats(): array
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $builder = Survey::query();

        if ($user->hasRole('admin-opd')) {
            $builder->where(function ($q) use ($user) {
                $q->where('created_by', $user->id)
                    ->orWhere('opd_id', $user->opd_master_id);
            });
        }

        $total = (clone $builder)->count();
        $active = (clone $builder)->where('is_active', true)->count();
        $public = (clone $builder)->where('visibility', 'public')->count();
        $private = (clone $builder)->where('visibility', 'private')->count();

        return [
            'total' => $total,
            'active' => $active,
            'public' => $public,
            'private' => $private,
        ];
    }

    public function suggestSurveys(string $query): array
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $builder = Survey::with('opd');

        if ($user->hasRole('admin-opd')) {
            $builder->where(function ($q) use ($user) {
                $q->where('created_by', $user->id)
                    ->orWhere('opd_id', $user->opd_master_id);
            });
        }

        return $builder->where('title', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($survey) {
                return [
                    'id' => $survey->uuid,
                    'title' => $survey->title,
                    'opd' => $survey->opd->name ?? 'N/A',
                    'visibility' => $survey->visibility,
                    'is_active' => $survey->is_active,
                ];
            })
            ->toArray();
    }
}
