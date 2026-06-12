<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use App\Repositories\EnrollmentRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StudentAccountService
{
    public function syncFromAdminRequest(User $user, FormRequest $request): void
    {
        $user->update([
            'sales_team_id' => $request->filled('sales_team_id') ? $request->sales_team_id : null,
        ]);

        if (!$request->filled('course_id')) {
            return;
        }

        $course = Course::withoutGlobalScopes()->find($request->course_id);
        if (!$course) {
            return;
        }

        $isPaid = $request->input('payment_status', 'unpaid') === 'paid';
        $salesTeamId = $request->sales_team_id ?: $user->sales_team_id;

        $enrollment = EnrollmentRepository::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        $transaction = TransactionRepository::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->latest('id')
            ->first();

        if ($isPaid) {
            if (!$enrollment) {
                $enrollment = EnrollmentRepository::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'coupon_id' => null,
                    'course_price' => (int) ($course->price ?? 0),
                    'discount_amount' => 0,
                    'certificate_user_name' => $user->name,
                ]);
            }

            $transactionData = [
                'course_id' => $course->id,
                'enrollment_id' => $enrollment->id,
                'user_id' => $user->id,
                'course_title' => $course->title,
                'user_phone' => $user->phone,
                'payment_amount' => $course->price ?? 0,
                'payment_method' => 'manual',
                'sales_team_id' => $salesTeamId,
                'is_paid' => true,
                'paid_at' => now(),
            ];

            if ($transaction) {
                $transaction->update($transactionData);
            } else {
                TransactionRepository::create(array_merge($transactionData, [
                    'identifier' => $this->generateIdentifier(),
                ]));
            }

            return;
        }

        if ($enrollment) {
            $enrollment->delete();
        }

        if ($transaction) {
            $transaction->update([
                'is_paid' => false,
                'paid_at' => null,
                'enrollment_id' => null,
            ]);
        } else {
            TransactionRepository::create([
                'identifier' => $this->generateIdentifier(),
                'course_id' => $course->id,
                'user_id' => $user->id,
                'course_title' => $course->title,
                'user_phone' => $user->phone,
                'payment_amount' => $course->price ?? 0,
                'payment_method' => 'manual',
                'sales_team_id' => $salesTeamId,
                'is_paid' => false,
            ]);
        }
    }

    public function formDefaults(User $user): array
    {
        $enrollment = $user->enrollments()->latest('id')->first();
        $transaction = null;

        if ($enrollment) {
            $transaction = TransactionRepository::query()
                ->where('user_id', $user->id)
                ->where('course_id', $enrollment->course_id)
                ->latest('id')
                ->first();
        } else {
            $transaction = TransactionRepository::query()
                ->where('user_id', $user->id)
                ->whereNotNull('course_id')
                ->latest('id')
                ->first();
        }

        $courseId = $enrollment?->course_id ?? $transaction?->course_id;
        $paymentStatus = 'unpaid';

        if ($transaction) {
            $paymentStatus = $transaction->is_paid ? 'paid' : 'unpaid';
        } elseif ($enrollment) {
            $paymentStatus = 'paid';
        }

        return [
            'selectedCourseId' => $courseId,
            'selectedSalesTeamId' => $user->sales_team_id,
            'paymentStatus' => $paymentStatus,
        ];
    }

    private function generateIdentifier(): string
    {
        return Str::lower(Str::random(16));
    }
}
