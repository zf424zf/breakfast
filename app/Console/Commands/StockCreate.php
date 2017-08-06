<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product\Products;
use App\Models\Stock;

class StockCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '按日期创建商品库存';

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
        $products = Products::all();
        for ($i = 0; $i < 30; $i++) {
            $date = date('Ymd', time() + 86400 * $i);
            foreach ($products as $product) {
                if (!Stock::where('date', $date)->where('product_id', $product['id'])->count()) {
                    $data = [
                        'date'       => $date,
                        'product_id' => $product['id'],
                        'stock'      => 9999,
                    ];
                    (new Stock($data))->save();
                }
            }
        }
    }
}
