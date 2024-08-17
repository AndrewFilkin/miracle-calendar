<?php


namespace App\Services\Api\Task;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class ShowAllTaskToAdminService
{
    public $answer;

    public function showTask(array $data, $id)
    {

        if (empty($data)) {
            $tasks = Task::paginate(30);
            return $this->answer = response()->json($tasks);
        }

        $filterFirst = $data['filterFirst'];

        if (array_key_exists('filterSecond', $data)) {
            $filterSecond = $data['filterSecond'];
        } else {
            $filterSecond = null;
        }

        switch ($filterFirst) {
            case 'asc':
                $tasks = Task::orderBy('name', 'asc')
                    ->paginate(30);
                return $this->answer = response()->json($tasks);

            case 'desc':
                $tasks = Task::orderBy('name', 'desc')
                    ->paginate(30);
                return $this->answer = response()->json($tasks);

            case 'completed':
                switch ($filterSecond) {
                    case 'asc':
                        $tasks = Task::where('is_completed', '=', true)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $tasks = Task::where('is_completed', '=', true)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $tasks = Task::where('is_completed', '=', true)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'not_completed':
                switch ($filterSecond) {
                    case 'asc':
                        $tasks = Task::where('is_completed', '=', false)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $tasks = Task::where('is_completed', '=', false)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $tasks = Task::where('is_completed', '=', false)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }
            case 'expired':
                switch ($filterSecond) {
                    case 'asc':
                        $currentDate = Carbon::now();
                        $tasks = Task::where('end_date', '<', $currentDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $currentDate = Carbon::now();
                        $tasks = Task::where('end_date', '<', $currentDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $currentDate = Carbon::now();
                        $tasks = Task::where('end_date', '<', $currentDate)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'not_expired':
                switch ($filterSecond) {
                    case 'asc':
                        $currentDate = Carbon::now();
                        $tasks = Task::where('end_date', '>', $currentDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $currentDate = Carbon::now();
                        $tasks = Task::where('end_date', '>', $currentDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $currentDate = Carbon::now();

                        $tasks = Task::where('end_date', '>', $currentDate)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'without_expired':
                switch ($filterSecond) {
                    case 'asc':
                        $tasks = Task::whereNull('end_date')
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $tasks = Task::whereNull('end_date')
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $tasks = Task::whereNull('end_date')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'current_date':
                switch ($filterSecond) {
                    case 'asc':
                        $currentDate = Carbon::now();
                        $tasks = Task::whereDate('start_date', '=', $currentDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                    case 'desc':
                        $currentDate = Carbon::now();
                        $tasks = Task::whereDate('start_date', '=', $currentDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                    default:
                        $currentDate = Carbon::now();
                        $tasks = Task::whereDate('start_date', '=', $currentDate)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'specific_date':
                switch ($filterSecond) {
                    case 'asc':
                        $specificDate = Carbon::parse($data['specific_date']);
                        $tasks = Task::whereDate('start_date', '=', $specificDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                    case 'desc':
                        $specificDate = Carbon::parse($data['specific_date']);
                        $tasks = Task::whereDate('start_date', '=', $specificDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                    default:
                        $specificDate = Carbon::parse($data['specific_date']);
                        //Если specific_date не была указана
                        if ($specificDate->minute == Carbon::now()->minute) {
                            return $this->answer = response()->json(['message' => 'Task not found'], 404);
                        }

                        $tasks = Task::whereDate('start_date', '=', $specificDate)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'between_date':
                switch ($filterSecond) {
                    case 'asc':
                        $startDate = Carbon::parse($data['start_date'])->startOfDay();
                        $endDate = Carbon::parse($data['end_date'])->endOfDay();
                        $tasks = Task::whereBetween('start_date', [$startDate, $endDate])
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $startDate = Carbon::parse($data['start_date'])->startOfDay();
                        $endDate = Carbon::parse($data['end_date'])->endOfDay();
                        $tasks = Task::whereBetween('start_date', [$startDate, $endDate])
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $startDate = Carbon::parse($data['start_date'])->startOfDay();
                        $endDate = Carbon::parse($data['end_date'])->endOfDay();
                        $tasks = Task::whereBetween('start_date', [$startDate, $endDate])
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }
            case 'newest':
                switch ($filterSecond) {
                    case 'asc':
                        $tasks = Task::orderBy('created_at', 'asc')
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $tasks = Task::orderBy('created_at', 'desc')
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $tasks = Task::orderBy('created_at', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }
            case 'oldest':
                switch ($filterSecond) {
                    case 'asc':
                        $tasks = Task::orderBy('created_at', 'asc')
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $tasks = Task::orderBy('created_at', 'asc')
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                    default:
                        $tasks = Task::orderBy('created_at', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }
            default:
                $tasks = Task::paginate(30);
                return $this->answer = response()->json($tasks);
        }
    }
}
