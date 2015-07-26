<div class="blog-image" ng-show="images" ng-repeat="img in images">

    <form ng-submit="ctrl.updateImage(img)" novalidate name="imageForm">

        <div class="form-group">
            <img class="img-responsive" ng-src="@{{ img.sizes[0].path  }}"/>

            <i class="fa fa-remove" ng-click="ctrl.deleteImage(img)"></i>
        </div>

        <div class="form-group">
            <input autocomplete="off" ng-change="ctrl.updateImage(img)" class="form-control" type="text" ng-model="img.translations[locale].title"/>
        </div>
    </form>

</div>

<div class="clearfix"></div>

<form action="" class="dropzone" dropzone="dropzone">
    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
</form>