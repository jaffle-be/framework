<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('blog::admin.post-images') }}</h5>
    </div>


    <div class="ibox-content">

        <div class="blog-image" ng-show="vm.post.images" ng-repeat="img in vm.post.images">

            <form ng-submit="vm.updateImage(img)" novalidate name="imageForm">

                <div class="form-group">
                    <img class="img-responsive" ng-src="@{{ img.sizes[0].path }}"/>

                    <i class="fa fa-remove" ng-click="vm.deleteImage(img.id)"></i>
                </div>

                <div class="form-group">
                    <input ng-change="vm.updateImage(img)" class="form-control" type="text" name="@{{ locale.locale }}" ng-model="img.translations[locale.locale].title"/>
                </div>
            </form>

        </div>

        <div class="clearfix"></div>

        <form action="" class="dropzone" dropzone="dropzone">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </form>
    </div>

</div>