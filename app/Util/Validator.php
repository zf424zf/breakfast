<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 15/7/28
 * Time: 下午3:55
 */

namespace App\Util;

use Illuminate\Validation\Validator as baseValidator;

class Validator extends baseValidator
{

    /**
     * @param $attribute
     * @param $value
     * @return int
     * 校验手机号码
     */
    protected function validatePhone($attribute, $value)
    {
        return preg_match("/1[34578]{1}\d{9}$/", $value);
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     * 判断金额,最小数为0.01
     */
    protected function validateAmount($attribute, $value)
    {
        $value = floatval($value);
        return $value > 0;
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     * 校验多个ID 形如1,2,3,4 或者 [1,2,3,4]
     */
    protected function validateIds($attribute, $value)
    {
        if (empty($value))
            return false;
        if (!is_array($value)) {
            $value = explode(',', $value);
        }
        foreach ($value as $v) {
            if (!is_numeric($v) || $v <= 0) {
                return false;
            }
        }
        return true;
    }

    /**
     * 身份证号验证
     */
    protected function validateIdentify($attribute, $vStr)
    {

        $vCity = array (
            '11', '12', '13', '14', '15', '21', '22',
            '23', '31', '32', '33', '34', '35', '36',
            '37', '41', '42', '43', '44', '45', '46',
            '50', '51', '52', '53', '54', '61', '62',
            '63', '64', '65', '71', '81', '82', '91',
        );

        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;

        if (!in_array(substr($vStr, 0, 2), $vCity)) return false;

        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);

        if ($vLength == 18) {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }

        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
        if ($vLength == 18) {
            $vSum = 0;

            for ($i = 17; $i >= 0; $i--) {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr, 11));
            }

            if ($vSum % 11 != 1) return false;
        }

        return true;
    }

}