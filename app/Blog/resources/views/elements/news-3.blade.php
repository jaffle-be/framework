<!-- News v3 -->
<div class="row margin-bottom-20">
    <div class="col-sm-5 sm-margin-bottom-20">

        <?php

        $img = $post->images->first() && $post->images->first()->sizes->first() ? $post->images->first()->sizes->first() : false;
        ?>

        <a href="{{ route('store.blog.show', [$post]) }}">
            <img class="img-responsive" src="{{ $img ? asset($img->path) : '' }}" alt="">
        </a>
    </div>
    <div class="col-sm-7">
        <div class="news-v3">
            <ul class="list-inline posted-info">
                <li>{{ Lang::get('blog::post-by') }} <a href="">{{ $post->user->name }}</a></li>
                @foreach($post->tags as $tag)
                <li>In <a href="#">{{ $tag->name }}</a></li>
                @endforeach
                <li>Posted {{ $post->published_at->format('d M, Y') }}</li>
            </ul>

            <h2><a href="{{ route('store.blog.show', [$post]) }}">{{ $post->title }}</a></h2>

            <p>{{ $post->extract }}</p>
            <ul class="post-shares">
                <li>
                    <a href="#">
                        <i class="rounded-x icon-speech"></i>
                        <span>5</span>
                    </a>
                </li>
                <li><a href="#"><i class="rounded-x icon-share"></i></a></li>
                <li><a href="#"><i class="rounded-x icon-heart"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<!--/end row-->
<!-- End News v3 -->

<div class="clearfix margin-bottom-20">
    <hr>
</div>


{{--<!-- News v3 -->--}}
{{--<div class="row margin-bottom-20">--}}
    {{--<div class="col-sm-5 sm-margin-bottom-20">--}}
        {{--<div class="responsive-video">--}}
            {{--<iframe src="//player.vimeo.com/video/93094247?title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-sm-7">--}}
        {{--<div class="news-v3">--}}
            {{--<ul class="list-inline posted-info">--}}
                {{--<li>By Alexander Jenni</li>--}}
                {{--<li>In <a href="#">Design</a></li>--}}
                {{--<li>Posted January 24, 2015</li>--}}
            {{--</ul>--}}
            {{--<h2><a href="#">Awesome post “VIDEO”</a></h2>--}}

            {{--<p>Nullam elementum tincidunt massa, a pulvinar leo ultricies ut. Ut fringilla lectus tellus, imperdiet molestie est volutpat at. Sed viverra cursus nibh, sed consectetur ipsum sollicitudin sed. Cras erat est, euismod id congue sed, sollicitudin sed odio. Nullam non metus in mi rhoncus efficitur...</p>--}}
            {{--<ul class="post-shares">--}}
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="rounded-x icon-speech"></i>--}}
                        {{--<span>5</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li><a href="#"><i class="rounded-x icon-share"></i></a></li>--}}
                {{--<li><a href="#"><i class="rounded-x icon-heart"></i></a></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--<!--/end row-->--}}
{{--<!-- End News v3 -->--}}

{{--<div class="clearfix margin-bottom-20">--}}
    {{--<hr>--}}
{{--</div>--}}

