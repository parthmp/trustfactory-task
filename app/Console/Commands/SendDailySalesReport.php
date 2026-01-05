<?php

namespace App\Console\Commands;

use App\Mail\DailySalesReportMail;
use App\Repositories\OrderRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily sales report to admin';

    /**
     * Execute the console command.
     */
    public function handle(OrderRepository $orderRepository){

        $orders = $orderRepository->fetchTodaysOrders();

        if ($orders->isEmpty()) {
            $this->info('No orders today.');
            return;
        }

        // Send email
        Mail::to(config('constants.admin_email'))->send(new DailySalesReportMail($orders));

        $this->info('Daily sales report sent.');
    }
}
