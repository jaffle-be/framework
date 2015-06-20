<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('blog::admin.post-images') }}</h5>
    </div>


    <div class="ibox-content">

        <div class="blog-image" ng-show="vm.post.images" ng-repeat="img in vm.post.images">

            <div class="row">

                <form ng-submit="vm.updateImage(img)" novalidate name="imageForm">

                    <div class="col-xs-12 col-md-6">
                        <img class="img-responsive" ng-src="@{{ img.sizes[0].path }}"/>

                        <div class="controls">
                            <button class="btn btn-danger" ng-click="vm.deleteImage(img.id)">{{ Lang::get('blog::admin.delete') }}</button>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6">
                        <div class="form-group" ng-repeat="locale in vm.options.locales">
                            <label>@{{ locale.locale }}</label>
                            <input ng-change="vm.updateImage(img)" class="form-control" type="text" name="@{{ locale.locale }}" ng-model="img.translations[locale.locale].title"/>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <form action="" class="dropzone" dropzone="dropzone">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </form>
    </div>

</div>