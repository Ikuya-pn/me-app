<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\Work;
use App\Models\MonthlySalary;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Carbon\CarbonInterval;
use Carbon\Carbon;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workers = Worker::select('id', 'name')->get();
        return Inertia::render('Admin/Worker/Index', [
            'workers' => $workers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Worker/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('workers')->ignore($request->id)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $worker = new Worker();
        
        $worker->name = $request->name;
        $worker->email = $request->email;
        $worker->password = Hash::make($request->password);
        $worker->hourly_wage = $request->hourly_wage;
        
        $worker->save();

        return to_route('admin.worker.index')
            ->with(['status' => 'success', 'message' => 'スタッフを登録しました。']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $worker = Worker::findOrFail($id);

        $monthlySalaries = MonthlySalary::where('worker_id', $worker->id)   
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('Admin/Worker/Show', [
            'worker' => $worker,
            'monthly_salaries' => $monthlySalaries,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $worker = Worker::findOrFail($id);
        return Inertia::render('Admin/Worker/Edit', [
            'worker' => $worker,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('workers')->ignore($request->id)],
            'hourly_wage' => ['integer'],
        ]);

        $updateWorker = Worker::findOrFail($id);
        
        $updateWorker->update([
            'name' => $request->name,
            'email' => $request->email,
            'hourly_wage' => $request->hourly_wage,
        ]);

        return to_route('admin.worker.index')
            ->with(['status' => 'success', 'message' => 'スタッフ情報を更新しました。']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Worker::findOrFail($id)->delete();

        return to_route('admin.worker.index')
            ->with(['status' => 'danger', 'message' => 'ワーカーを完全に削除しました。']);
    }

    public function salary_show(string $id)
    {
        $monthlySalary = MonthlySalary::findOrFail($id);

        $worker = $monthlySalary->worker->name;

        //先月の年月を取得
        $currentDate = Carbon::now();
        $previousMonth = $currentDate->subMonth();
        $year = $previousMonth->year;
        $month = $previousMonth->month;

        // 1月の場合は前年の12月を取得する
        if ($month == 0) {
            $year -= 1;
            $month = 12;
        }

        //スタッフ一人の合計時間を取得
        $timeInSeconds = Work::where('worker_id', $monthlySalary->worker->id)
            ->selectRaw('SUM(TIME_TO_SEC(result_time)) AS total_time_seconds')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->value('total_time_seconds');

        $totalInterval = CarbonInterval::seconds($timeInSeconds)->cascade();
        $hour = $totalInterval->format('%d') * 24;
        $hour += $totalInterval->format('%h');
        $hour = $hour . '時間';
        $minute = $totalInterval->format('%i');
        $minute = $minute . '分';
        $result = $hour . $minute;
        
        return Inertia::render('Admin/Worker/SalaryShow',[
            'monthly_salary' => $monthlySalary,
            'result' => $result,
            'worker' => $worker,
        ]);
    }
}
