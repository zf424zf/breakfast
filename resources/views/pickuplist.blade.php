@extends('layout')
@section('title','待取货名单')
@section('resource')
    <!--css js-->
@endsection
@section('content')
    <div class="page-group">
        <div class="page">
            <!--头部开始-->
            <header class="bar bar-nav">
                <h1 class="title">待取货名单</h1>
            </header>
            <!--头部结束-->
            <!--待取货名单开始-->
            <div class="content">
                <div class="pick-up-stay">
                    <div class="location-box">
                        <div class="location"><span>取货日期: {{date('Y-m-d')}}</span></div>
                        <div class="staff">{{app('user')->nickname()}}</div>
                    </div>
                    <form action="{{url('pickuplist')}}" id="pickuplist_filter">
                        <div class="filter-list">
                            <select name="place_id" id="">
                                <option value="">选择取货点</option>
                                @foreach($places as $place)
                                    <option value="{{$place['id']}}"
                                            @if(request('place_id') == $place['id'])selected @endif
                                    >
                                        {{$place['name']}}
                                    </option>
                                @endforeach
                            </select>
                            <select name="pickuptime_id">
                                <option value="">选择取货时间段</option>
                                @foreach($pickuptimes as $pickuptime)
                                    <option value="{{$pickuptime['id']}}"
                                            @if(request('pickuptime_id') == $pickuptime['id'])selected @endif
                                    >
                                        {{$pickuptime['start']}} - {{$pickuptime['end']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <script>
                        $(function () {
                            $(document).on('change', '.filter-list select', function () {
                                $('#pickuplist_filter').submit();
                            })
                        })
                    </script>
                    @if(count($orders))
                        <table cellspacing="0" cellpadding="0" border="0">
                            <thead>
                            <tr>
                                <td width="20%">电话</td>
                                <td width="15%">用户名</td>
                                <td width="50%">商品</td>
                                <td width="15%">状态</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                @if($order['status'] == 1)
                                    <tr>
                                        <td>{{$order['tail']}}</td>
                                        <td>{{$order['name']}}</td>
                                        <td>
                                            @foreach($order['goods'] as $goods)
                                                {{$goods['product']['name']}} X {{$goods['count']}}
                                            @endforeach
                                        </td>
                                        <td><span>未取货</span></td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="4">
                                    <div class="space"></div>
                                </td>
                            </tr>
                            @foreach($orders as $order)
                                @if($order['status'] != 1)
                                    <tr>
                                        <td>{{$order['tail']}}</td>
                                        <td>{{$order['name']}}</td>
                                        <td>
                                            @foreach($order['goods'] as $goods)
                                                {{$goods['product']['name']}} X {{$goods['count']}}
                                            @endforeach
                                        </td>
                                        <td><span>已取货</span></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="no_data">暂无待取商品</div>
                    @endif
                </div>
            </div>
            <!--待取货名单结束-->
        </div>
@endsection