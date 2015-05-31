<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('blog::admin.post-images') }}</h5>
    </div>

    <div class="ibox-content">
        <form action="" class="dropzone" dropzone="dropzone">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </form>
    </div>

</div>
