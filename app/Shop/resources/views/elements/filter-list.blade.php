<div class="filter-results">

    @foreach($products as $product)

        <div class="list-product-description product-description-brd margin-bottom-30">
            <div class="row">
                <div class="col-sm-4">
                    <a href="shop-ui-inner.html"><img class="img-responsive sm-margin-bottom-20" src="{{ asset('/assets/img/blog/16.jpg') }}" alt=""></a>
                </div>
                <div class="col-sm-8 product-description">

                    <div class="overflow-h margin-bottom-5">

                        <ul class="list-inline overflow-h">
                            <li><h4 class="title-price"><a href="shop-ui-inner.html">{{ $product->name }}</a></h4></li>
                            <li><span class="gender text-uppercase">Men</span></li>
                            <li class="pull-right">
                                <ul class="list-inline product-ratings">
                                    @for($i=0; $i < 5; $i++)
                                        <li>
                                            <i class="rating{{ $product->rating > $i ? '-selected' : null }} fa fa-star"></i>
                                        </li>
                                    @endfor
                                </ul>
                            </li>
                        </ul>

                        <div class="margin-bottom-10">
                            <span class="title-price margin-right-10">{{ $product->price->first()->value }}</span>
                            <span class="title-price line-through">{{ $product->promotion->first()->value }}</span>
                        </div>

                        <p class="margin-bottom-20">
                            {{ $product->text }}
                        </p>

                        <ul class="list-inline add-to-wishlist margin-bottom-20">
                            <li class="wishlist-in">
                                <i class="fa fa-heart"></i>
                                <a href="#">Add to Wishlist</a>
                            </li>
                            <li class="compare-in">
                                <i class="fa fa-exchange"></i>
                                <a href="#">Add to Compare</a>
                            </li>
                        </ul>
                        <button type="button" class="btn-u btn-u-sea-shop">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

</div>

<div class="text-center">
    <ul class="pagination pagination-v2">
        <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
        <li><a href="#">1</a></li>
        <li class="active"><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
    </ul>
</div><!--/end pagination-->