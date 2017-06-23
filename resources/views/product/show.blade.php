<div class="close-btn"><img src="{{cdn('images/close.png')}}" alt=""/></div>
<img src="{{img_url($product['img'],330,165)}}" alt=""/>
<div class="txt">
    <h4>{{$product['name']}}</h4>
    <p>食材：{{$product['material']}}</p>
    <p>卡路里：{{$product['calori']}}</p>
    <div><span>推荐：</span>
        <ul>
            {!! str_repeat('<li class="solid"></li>',$product['recommend']) !!}
            {!! str_repeat('<li class="hollow"></li>',5 - $product['recommend']) !!}
        </ul>
    </div>
</div>
<div class="food-detail-footer">
    <div class="pull-left">￥{{$product['origin_price']}}</div>
    <a href="javascript:;" id="add-to-cart" data-id="{{$product['id']}}">加入购物车</a>
</div>