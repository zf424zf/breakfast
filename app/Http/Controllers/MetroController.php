<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/8
 * Time: 下午9:43
 */

namespace App\Http\Controllers;

use App\Models\Metro\Metro as MetroModel;
use App\Models\Metro\Place as PlaceModel;
use App\Models\Metro\Station as StationModel;

class MetroController extends Controller
{
    public function __construct()
    {
        $this->middleware('wechat.userinfo', ['except' => '']);
    }

    public function index()
    {
        $metros = MetroModel::with(['stations' => function ($query) {
            $query->orderBy('sort', 'DESC');
        }])->orderBy('sort', 'DESC')->get()->toArray();
        return view('metro', ['metros' => $metros]);
    }

    public function station($stationId)
    {
        $station = StationModel::where('id', $stationId)->with(['places' => function ($query) {
            $query->orderBy('sort', 'DESC');
        }])->with(['metros' => function ($query) {
            $query->orderBy('sort', 'DESC');
        }])->first();
        if (request('metro_id')) {
            $stations = MetroModel::where('id', request('metro_id'))->with(['stations' => function ($query) {
                $query->orderBy('sort', 'DESC');
            }])->first()->toArray();
        } else {
            $stations = [];
        }
        return view('station', ['station' => $station, 'stations' => $stations]);
    }
}