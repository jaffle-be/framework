<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('contact::admin.social_links') }}</h5>
    </div>

    <div class="ibox-content">

        @foreach($links as $link)
            <div class="form-group col-xs-6">

                <div class="input-group">
                    <div class="input-group-addon" title="{{ $link }}">
                        <i class="fa fa-{{$link}}" title="{{ $link }}"></i>
                    </div>

                    <div>
                        <input type="text" name="link_{{ $link}}" id="link_{{ $link}}" class="form-control"
                               ng-model="links.{{$link}}" ng-change="vm.save()" placeholder="{{ $link }}"/>
                    </div>
                </div>
            </div>

        @endforeach

        <div class="clearfix"></div>

    </div>

</div>
