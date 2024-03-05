<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Work;
use App\Models\Worker;
use App\Models\MonthlySalary;

class storeMonthlySalary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-monthly-salary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
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

        $workers = Worker::select('id')->get();

        foreach($workers as $worker){
            $salary = Work::where('worker_id', $worker->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->sum('salary');

            $days = Work::where('worker_id', $worker->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->count();

            // 給与データを追加する処理
            MonthlySalary::create([
                'worker_id' => $worker->id, // 従業員IDを設定する必要があります
                'year' => $year,
                'month' => $month,
                'days' => $days,
                'salary' => $salary, // 給与額を設定します
            ]);
        }
    }
}
