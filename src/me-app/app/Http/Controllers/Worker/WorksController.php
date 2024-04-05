<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\Worker;
use App\Models\FixWork;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Models\MonthlySalary;

class WorksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $worker = Worker::findOrFail(Auth::id());
        
        //今月のシフトを取得
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();
        $thisMonthsWorks = Work::where('worker_id', $worker->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // 現在の年月を取得
        $currentYear = now()->year;
        $currentMonth = now()->month;

        $workedDates = Work::whereYear('date', $currentYear)
                          ->whereMonth('date', $currentMonth)
                          ->where('worker_id', $worker->id)
                          ->select('date', 'result_time')
                          ->get();

        $salary = Work::whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->where('worker_id', $worker->id)
            ->sum('salary');

        return Inertia::render('Worker/Index', [
            'works' => $workedDates,
            'salary' => number_format($salary),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $date)
    {
        $existWork = Work::whereYear('date', now()->year)
            ->where('worker_id', Auth::id())
            ->whereMonth('date', now()->month)
            ->whereDay('date', $date)
            ->first();
        
        $existFixWork = FixWork::whereYear('date', now()->year)
            ->where('worker_id', Auth::id())
            ->where('necessity', '1')
            ->whereMonth('date', now()->month)
            ->whereDay('date', $date)
            ->first();

        return Inertia::render('Worker/Create', [
            'date' => $date,
            'existWork' => $existWork,
            'existFixWork' => $existFixWork,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $worker = Worker::findOrFail(Auth::id());

        $request->validate([
            'break_time' => ['integer']
        ]);

        $workedDate = date('Y-m-' . $request->date);

        if(!$request->is_locked){
            $locked = true;
        }

        // 労働時間を計算
        $totalMinutes = 0;
        list($hours, $minutes, $seconds) = sscanf($request->result_time, '%d:%d:%d');
        $totalMinutes += $hours * 60 + $minutes;
        
        //　給与合計を計算
        $totalHours =  $totalMinutes / 60;
        $salary = (string)floor($worker->hourly_wage * $totalHours);
        
        Work::create([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_time' => $request->break_time,
            'result_time' => $request->result_time,
            'salary' => $salary,
            'date' => $workedDate,
            'worker_id' => Auth::id(),
            'customer_id' => $request->customer_id,
            'is_locked' => $locked,
        ]);

        return to_route('worker.works.index')
        ->with(['status' => 'success', 'message' => 'シフトを登録しました。']);;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $worker = Worker::findOrFail(Auth::id());

        $request->validate([
            'break_time' => ['integer']
        ]);

        // 開始時刻と終了時刻、分単位の休憩時間を取得
        $startTime = Carbon::createFromTimeString($request->start_time);
        $endTime = Carbon::createFromTimeString($request->end_time);
        $breakTimeInMinutes = $request->break_time; // 分単位の休憩時間

        // 開始時刻から終了時刻までの経過時間を計算
        $elapsed = $startTime->diff($endTime);

        // 休憩時間を経過時間から差し引く
        $elapsedMinutes = ($elapsed->h * 60) + $elapsed->i; // 分単位の経過時間
        $elapsedMinutes -= $breakTimeInMinutes;

        // 分単位の経過時間を時間と分に変換
        $hours = floor($elapsedMinutes / 60); // 時間
        $minutes = $elapsedMinutes % 60; // 分

        // HH:MM 形式にフォーマット
        $resultTime = sprintf('%02d:%02d', $hours, $minutes);

        // 労働時間を計算
        $totalMinutes = 0;
        list($hours, $minutes, $seconds) = sscanf($resultTime, '%d:%d:%d');
        $totalMinutes += $hours * 60 + $minutes;

        //　給与合計を計算
        $totalHours =  $totalMinutes / 60;
        $salary = (string)floor($worker->hourly_wage * $totalHours);

        //勤務日をdate型に変更
        $workedDate = date('Y-m-' . $request->date);
    
        FixWork::create([
            'worker_id' => Auth::id(),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_time' => $request->break_time,
            'result_time' =>$resultTime,
            'salary' => $salary,
            'date' => $workedDate,
            'customer_id' => $request->customer_id,
            'necessity' => 1
        ]);

        return to_route('worker.works.index')
            ->with(['status' => 'success', 'message' => 'シフト修正の申請が完了しました。']);
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
