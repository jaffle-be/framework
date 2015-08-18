<div class="media-image-uploader" ng-class="{'col-md-6': limit == 1}">

    <div class="loader" ng-show="!loaded">

        <div class="sk-spinner sk-spinner-double-bounce">
            <div class="sk-double-bounce1"></div>
            <div class="sk-double-bounce2"></div>
        </div>

    </div>

    <div class="item" ng-show="loaded" ng-repeat="img in images track by $index" ng-class="{clearfix: $index%2==0, 'col-md-6':limit!=1}">

        <form ng-submit="ctrl.updateImage(img)" novalidate name="imageForm">

            <div class="media-image">
                <img class="img-responsive" ng-src="@{{ img.sizes[0].path  }}"/>

                <div class="tools">
                    <div class="tools-inner">
                        <i class="fa fa-trash" ng-click="ctrl.deleteImage(img)"></i>
                    </div>
                </div>
            </div>

            <div class="form-group" ng-hide="!locale">
                <input autocomplete="off" ng-change="ctrl.updateImage(img)" class="form-control" type="text" ng-model="img.translations[locale].title" placeholder="{{ Lang::get('media::admin.image-title') }}"/>
            </div>
        </form>

    </div>

    <div class="clearfix"></div>

</div>

<div ng-class="{'col-md-6': limit == 1}">
    <form action="" class="dropzone" dropzone="dropzone" ng-show="!locked || limit == 1">
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    </form>
</div>