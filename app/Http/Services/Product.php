<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/24
 * Time: 上午12:51
 */

namespace App\Http\Services;

use App\Models\Product\Products as ProductModel;
use App\Models\PickupTime as PickuptimeModel;

class Product
{
    /**
     * @param array $ids
     * @param null $date
     * @param null $placeId
     * @param null $pickuptimeId
     * @return mixed
     * 查询符合条件的商品
     */
    public static function gets($ids = [], $date = null, $placeId = null, $pickuptimeId = null)
    {
        $query = ProductModel::available();
        if ($ids) {
            $query->whereIn('id', $ids);
        }
        if ($date) {
            $weekday = date('w', strtotime($date)) + 1;
            $query->whereHas('saledays', function ($query) use ($weekday) {
                $query->where('weekday', $weekday);
            });
        }
        if ($placeId) {
            $query->whereHas('places', function ($query) use ($placeId) {
                $query->where('place_id', $placeId);
            });
        }
        if ($pickuptimeId) {
            $query->whereHas('pickuptimes', function ($query) use ($pickuptimeId) {
                $query->where('pickuptime_id', $pickuptimeId);
            });
        }
        $datas = $query->get()->keyBy('id')->toArray();
        if ($date && $pickuptimeId) {
            $pickuptime = PickuptimeModel::find($pickuptimeId)->toArray();
            foreach ($datas as $key => $data) {
                $datas[$key] = self::isEarlyBird($data, $date, $pickuptime);
            }
        }
        return $datas;
    }

    /**
     * @param array $product
     * @param $date
     * @param $pickuptime
     * @return array
     * 判断是否是早鸟价格
     */
    public static function isEarlyBird(array $product, $date, $pickuptime)
    {
        $earlyTime = strtotime($date . ' ' . $pickuptime['start']) - $product['early_time'] * 3600;
        $product['is_early'] = time() < $earlyTime ? true : false;
        $product['price'] = $product['is_early'] ? $product['early_price'] : $product['coupon_price'];
        return $product;
    }

    public static function setStock($productId, $stock)
    {
        return ProductModel::where('id', $productId)->update(['stock' => $stock]);
    }
}