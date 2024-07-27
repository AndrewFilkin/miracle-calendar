<?php


namespace App\Services\Api\Task;


use App\Models\User;
use Carbon\Carbon;
use function PHPUnit\Framework\isEmpty;

class ShowTaskService
{
    public $answer;

    public function showTask(array $data, $id)
    {

        if (empty($data)) {
            $user = User::find($id);
            $tasks = $user->tasks()->paginate(30);
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
                $user = User::find($id);
                $tasks = $user->tasks()
                    ->orderBy('name', 'asc')
                    ->paginate(30);
                return $this->answer = response()->json($tasks);

            case 'desc':
                $user = User::find($id);
                $tasks = $user->tasks()
                    ->orderBy('name', 'desc')
                    ->paginate(30);
                return $this->answer = response()->json($tasks);

            case 'completed':
                switch ($filterSecond) {
                    case 'asc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', true)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', true)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', true)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'not_completed':
                switch ($filterSecond) {
                    case 'asc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', false)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', false)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', false)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }
            case 'expired':
                switch ($filterSecond) {
                    case 'asc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '<', $currentDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '<', $currentDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '<', $currentDate)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'not_expired':
                switch ($filterSecond) {
                    case 'asc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '>', $currentDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '>', $currentDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $currentDate = Carbon::now();

                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '>', $currentDate)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'without_expired':
                switch ($filterSecond) {
                    case 'asc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereNull('end_date')
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereNull('end_date')
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereNull('end_date')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'current_date':
                switch ($filterSecond) {
                    case 'asc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $currentDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                    case 'desc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $currentDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                    default:
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $currentDate)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'specific_date':
                switch ($filterSecond) {
                    case 'asc':
                        $specificDate = Carbon::parse($data['specific_date']);
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $specificDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                    case 'desc':
                        $specificDate = Carbon::parse($data['specific_date']);
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $specificDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                    default:
                        $specificDate = Carbon::parse($data['specific_date']);
                        //Если specific_date не была указана
                        if ($specificDate->minute == Carbon::now()->minute) {
                            return $this->answer = response()->json(['message' => 'Task not found'], 404);
                        }

                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $specificDate)
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }

            case 'between_date':
                switch ($filterSecond) {
                    case 'asc':
                        $startDate = Carbon::parse($data['start_date'])->startOfDay();
                        $endDate = Carbon::parse($data['end_date'])->endOfDay();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereBetween('start_date', [$startDate, $endDate])
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    case 'desc':
                        $startDate = Carbon::parse($data['start_date'])->startOfDay();
                        $endDate = Carbon::parse($data['end_date'])->endOfDay();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereBetween('start_date', [$startDate, $endDate])
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);

                    default:
                        $startDate = Carbon::parse($data['start_date'])->startOfDay();
                        $endDate = Carbon::parse($data['end_date'])->endOfDay();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereBetween('start_date', [$startDate, $endDate])
                            ->paginate(30);
                        return $this->answer = response()->json($tasks);
                }
            case 'newest':
                $user = User::find($id);
                $tasks = $user->tasks()
                    ->orderBy('created_at', 'desc')
                    ->paginate(30);
                return $this->answer = response()->json($tasks);
            case 'oldest':
                $user = User::find($id);
                $tasks = $user->tasks()
                    ->orderBy('created_at', 'asc')
                    ->paginate(30);
                return $this->answer = response()->json($tasks);
            default:
                $user = User::find($id);
                $tasks = $user->tasks()->paginate(30);
                return $this->answer = response()->json($tasks);
        }
    }
}
