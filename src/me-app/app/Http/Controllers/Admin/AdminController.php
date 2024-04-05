<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FixWork;
use App\Models\Work;
use App\Models\Worker;
use Inertia\Inertia;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //修正申請の件数を取得
        $fixWorksCount = FixWork::with('worker')
            ->where('necessity', 1)
            ->count();

        // 修正申請があるワーカーを取得
        $workers = FixWork::where('necessity', 1)
            ->distinct('worker_id')
            ->pluck('worker_id');
        $workersWithNames = Worker::whereIn('id', $workers)->get();

        return Inertia::render('Admin/Index', [
            'workers_with_names' => $workersWithNames,
            'fix_works_count' => $fixWorksCount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $worker = Worker::findOrFail($id);

        $fixWorks = FixWork::where('worker_id', $id)
            ->where('necessity', 1)
            ->orderBy('date', 'asc')
            ->get();

        $figureWorks = FixWork::where('worker_id', $id)
            ->where('necessity', '1')
            ->distinct('date')
            ->pluck('date');

        $previousWorks = Work::where('worker_id', $id)
            ->whereIn('date', $figureWorks)
            ->orderBy('date', 'asc')
            ->get();

        foreach($previousWorks as $key => $work){
            $work->update([
                'start_time' => $fixWorks[$key]->start_time,
                'end_time' => $fixWorks[$key]->end_time,
                'break_time' => $fixWorks[$key]->break_time,
                'result_time' => $fixWorks[$key]->result_time,
                'salary' => $fixWorks[$key]->salary,
                'customer_id' => $fixWorks[$key]->customer_id,
            ]);

            
        }

        foreach($fixWorks as $work){
            $work->update([
                'necessity' => 0,
            ]);
        }
        
        return to_route('admin.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $worker = Worker::findOrFail($id);

        //修正申請があるシフトを取得
        $fixWorks = FixWork::where('worker_id', $id)
            ->where('necessity', '1')
            ->orderBy('date', 'asc')
            ->get();

        //修正前のシフトを取得
        $figureWorks = FixWork::where('worker_id', $id)
            ->where('necessity', '1')
            ->distinct('date')
            ->pluck('date');

        $previousWorks = Work::where('worker_id', $id)
            ->whereIn('date', $figureWorks)
            ->orderBy('date', 'asc')
            ->get();
        
        return Inertia::render('Admin/Show', [
            'fix_works' => $fixWorks,
            'previous_works' => $previousWorks,
            'worker_id' => $id,
            'worker' => $worker
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
