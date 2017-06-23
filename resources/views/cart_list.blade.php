<h4><span>购物车</span></h4>
@if($count)
    @foreach($datas as $date => $data)
    @if(array_sum($data) > 0)
    <h6>{{chinese_week(strtotime($date))}} {{date('m-d',strtotime($date))}}</h6>
    <div class="list-block">
        <ul>
            @foreach($data as $productId => $count)
            <li class="item-content" data-date="{{$date}}" data-count="{{$count}}" data-id="{{$productId}}">
                <div class="item-inner">
                    <div class="item-title">{{$products[$productId]['name']}}</div>
                    <div class="item-after">
                        <div class="pull-left">
                            ￥{{$products[$productId]['coupon_price']}}
                        </div>
                        <div class="pull-right food-cart">
                            <a href="javascript:;" class="food-reduce"></a>
                            <span class="food-count">{{$count}}</span>
                            <a href="javascript:;" class="food-add"></a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
    @endforeach
@else
    <div class="cart-empty">
        购物车空空如也,快去挑选您的货物吧
    </div>
@endif
