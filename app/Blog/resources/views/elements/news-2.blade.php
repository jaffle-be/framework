<div class="row news-v2 margin-bottom-50">

    @foreach($posts as $post)
        <div class="col-sm-4">
            <div class="news-v2-badge">
                <?php
                $image = $post->images->first() && $post->images->first()->sizes->first() ? $post->images->first()->sizes->first() : false;
                ?>

                <a href="{{ route('store.blog.show', [$post]) }}">
                    <img class="img-responsive" src="{{ $image ? asset($image->path) : '' }}" alt="">
                </a>

                <p>
                    <span>{{ $post->published_at->format('d') }}</span>
                    <small>{{ $post->published_at->format('M y') }}</small>
                </p>
            </div>
            <div class="news-v2-desc">
                <h3><a href=" {{ route('store.blog.show', [$post]) }}">{{ $post->title}}</a></h3>
                <small>By {{ $post->user->name }} |
                    <? $teller = 0 ?>
                    @foreach($post->tags as $tag)
                        <? $teller++ ?>
                        <a href="#">{{ $tag->name }}</a>
                        @if($teller != $post->tags->count())
                            ,
                        @endif
                    @endforeach
                </small>
                <p>{{ $post->extract }}</p>
            </div>
        </div>
    @endforeach
</div>