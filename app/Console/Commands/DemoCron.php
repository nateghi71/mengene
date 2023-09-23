<?php
//
//namespace App\Console\Commands;
//
//use App\Models\Customer;
//use Carbon\Carbon;
//use Illuminate\Console\Command;
//
//class DemoCron extends Command
//{
//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//    protected $signature = 'demo:cron';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = 'Command description';
//
//    /**
//     * Create a new command instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        parent::__construct();
//    }
//
//    /**
//     * Execute the console command.
//     *
//     * @return int
//     */
//    public function handle()
//    {
////        dd('hello');
////        \Log::info("Cron is working fine!");
//
//        $pro = Customer::where('expiry_date', '<', Carbon::now())->get();
//        $pro['status'] = 0;
//        dd($pro->all());
//
//        $pro->update($pro->all());
//    }
//}
