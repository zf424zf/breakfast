<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 15/12/2
 * Time: 下午8:20
 */

namespace App\Console\Commands\Order;

use Illuminate\Console\Command;

use App\Http\Services\Refund as RefundService;

class RefundQuery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refund:query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定时查询退款结果';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('db')->table('order_refund')->where('status', RefundService::PROCESSING)->orderBy('id','DESC')->chunk(10, function ($refunds) {
            foreach ($refunds as $refund) {
                (new RefundService($refund->refund_flow))->query();
            }
        });
    }
}