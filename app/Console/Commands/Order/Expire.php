<?php

namespace App\Console\Commands\Order;

use Illuminate\Console\Command;
use App\Http\Services\Order as OrderService;

class Expire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单自动过期脚本';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expire = setting('order_expire_time', 30) * 60;
        app('db')->table('orders')->where('created_at', '<', time() - $expire)->where('status', OrderService::WAITPAY)->orderBy('id', 'DESC')->chunk(10, function ($orders) {
            foreach ($orders as $order) {
                (new OrderService($order->order_id))->expire();
            }
        });
    }
}
