<?php

namespace App\Http\Controllers;

use App\Models\StudentSessionLimit;
use Illuminate\Http\Request;

class StudentSessionLimitController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_external_id' => ['required', 'string', 'max:64'],
            'student_name' => ['nullable', 'string', 'max:255'],
            'allow_multiple_sessions' => ['nullable', 'boolean'],
            'max_sessions' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $allowMultiple = $request->boolean('allow_multiple_sessions');
        $maxSessions = $allowMultiple ? max(2, (int) $validated['max_sessions']) : 1;

        StudentSessionLimit::updateOrCreate(
            ['student_external_id' => trim($validated['student_external_id'])],
            [
                'student_name' => trim((string) ($validated['student_name'] ?? '')) ?: null,
                'allow_multiple_sessions' => $allowMultiple,
                'max_sessions' => $maxSessions,
            ]
        );

        return redirect()
            ->route('settings.index', ['tab' => 'student_limits'])
            ->with('success', 'Student session limit saved.');
    }

    public function destroy(StudentSessionLimit $studentSessionLimit)
    {
        $studentSessionLimit->delete();

        return redirect()
            ->route('settings.index', ['tab' => 'student_limits'])
            ->with('success', 'Student session limit removed.');
    }
}
