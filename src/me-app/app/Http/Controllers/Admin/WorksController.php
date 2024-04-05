<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Work;
use App\Models\Worker;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorksController extends Controller
{
    public function index()
    {
        $works = Work::select('id', 'result_time', 'date', 'worker_id', 'customer_id')
            ->with('worker', 'customer')
            ->orderBy('id', 'desc')
            ->paginate(50);

        return Inertia::render('Admin/Works/Index', [
            'works' => $works,
        ]);
    }

    public function edit($id)
    {
        $work = Work::with('worker')->findOrFail($id);

        return Inertia::render('Admin/Works/Edit', [
            'existWork' => $work,
        ]);
    }

    public function update(Request $request, $id)
    {
        $worker = Worker::findOrFail($request->worker_id);

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

        $work = Work::findOrFail($id);
        $work->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_time' => $request->break_time,
            'result_time' => $resultTime,
            'salary' => $salary,
            'date' => $request->date,
            'worker_id' => $request->worker_id,
            'customer_id' => $request->customer_id,
            'is_locked' => $request->is_locked,
        ]);

        return to_route('admin.works.index')
            ->with(['status' => 'success', 'message' => 'シフト情報を更新しました。']);
    }

    public function destroy($id)
    {
        Work::findOrFail($id)->delete();

        return to_route('admin.works.index')
            ->with(['status' => 'alert', 'message' => 'シフトを削除しました。']);
    }
}
