<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('blog::admin.post-images') }}</h5>
    </div>


    <div class="ibox-content">

        <div class="blog-image" ng-repeat="img in vm.post.images">

            <div class="row" ng-show="img.sizes[0]">

                <div class="col-xs-12 col-md-6">
                    <img ng-src="@{{ img.sizes[0].path }}"/>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group" ng-repeat="locale in vm.options.locales">
                        <label>@{{ locale.locale }}</label>
                        <input class="form-control" type="text" name="@{{ locale.locale }}" id="" value="@{{ translation[locale.locale].title }}"/>
                    </div>
                </div>
            </div>

        </div>

        <form action="" class="dropzone" dropzone="dropzone">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </form>
    </div>

</div>
