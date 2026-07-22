<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Schedule;

class MapelController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $student = Student::findByUser($user);

        if (!$student) {
            $student = Student::first();
        }

        if (!$student) {
            $student = (object)[
                'id'       => 0,
                'name'     => $user->name,
                'nis'      => '-',
                'class_id' => '-',
                'email'    => $user->email,
            ];
        }

        $dayNameMap = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $dayLabels = ['Senin' => 'Sen', 'Selasa' => 'Sel', 'Rabu' => 'Rab', 'Kamis' => 'Kam', 'Jumat' => 'Jum', 'Sabtu' => 'Sab'];
        $dayOrder = array_keys($dayLabels);

        $schedules = Schedule::with(['subject', 'teacher'])
            ->byClass($student->class_id)
            ->active()
            ->get()
            ->unique(function ($schedule) {
                $start = $schedule->start_time instanceof \Carbon\Carbon ? $schedule->start_time->format('H:i') : $schedule->start_time;
                $end = $schedule->end_time instanceof \Carbon\Carbon ? $schedule->end_time->format('H:i') : $schedule->end_time;
                return implode('|', [
                    $schedule->subject_id,
                    $schedule->day,
                    $start,
                    $end,
                ]);
            })
            ->sortBy(function ($schedule) use ($dayOrder) {
                $dayIndex = array_search($schedule->day, $dayOrder);
                $time = $schedule->start_time instanceof \Carbon\Carbon ? $schedule->start_time->format('H:i') : $schedule->start_time;
                return sprintf('%02d%s', $dayIndex === false ? 99 : $dayIndex, $time);
            });

        $scheduleByDay = $schedules->groupBy('day');
        $subjectGroups = $schedules->groupBy('subject_id');
        $maxSessions = $subjectGroups->map(function ($group) {
            return $group->count();
        })->max() ?: 1;

        $subjects = $subjectGroups->map(function ($group) use ($dayOrder, $maxSessions) {
            $item = $group->first();
            $times = $group->sortBy(function ($schedule) use ($dayOrder) {
                $dayIndex = array_search($schedule->day, $dayOrder);
                $time = $schedule->start_time instanceof \Carbon\Carbon ? $schedule->start_time->format('H:i') : $schedule->start_time;
                return sprintf('%02d%s', $dayIndex === false ? 99 : $dayIndex, $time);
            })->map(function ($schedule) {
                return $schedule->day . ' ' . ($schedule->start_time instanceof \Carbon\Carbon ? $schedule->start_time->format('H:i') : $schedule->start_time) . '–' . ($schedule->end_time instanceof \Carbon\Carbon ? $schedule->end_time->format('H:i') : $schedule->end_time);
            })->unique()->values();

            return [
                'name' => $item->subject->name ?? '-',
                'teacher' => $item->teacher?->name ?? '-',
                'times' => $times,
                'sessions' => $group->count(),
                'progress' => round($group->count() / $maxSessions * 100),
            ];
        })->values();

        $totalSubjects = $subjects->count();
        $totalMinutes = $schedules->sum(function ($schedule) {
            if (!$schedule->start_time || !$schedule->end_time) {
                return 0;
            }
            return max(0, $schedule->end_time->diffInMinutes($schedule->start_time));
        });
        $totalHours = (int) round($totalMinutes / 60);
        $todayName = $dayNameMap[today()->format('l')] ?? today()->format('l');
        $currentDayIndex = array_search($todayName, $dayOrder);
        $currentDayIndex = $currentDayIndex === false ? 0 : $currentDayIndex;

        return view('mapel.index', compact(
            'student',
            'schedules',
            'scheduleByDay',
            'subjects',
            'dayLabels',
            'dayOrder',
            'todayName',
            'currentDayIndex',
            'totalSubjects',
            'totalHours'
        ));
    }
}