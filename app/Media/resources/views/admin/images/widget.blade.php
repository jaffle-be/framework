<div class="row">
    <div class="input-image" ng-class="{'col-md-6': limit == 1}">

        <div class="loader" ng-show="!loaded">

            <div class="sk-spinner sk-spinner-double-bounce">
                <div class="sk-double-bounce1"></div>
                <div class="sk-double-bounce2"></div>
            </div>

        </div>

        <div class="row row-eq-height list">
            <div class="item" ng-show="loaded" ng-repeat="img in images track by $index" ng-class="{clearfix: $index%2==0, 'col-md-6':limit!=1}">

                <form ng-submit="ctrl.updateImage(img)" novalidate name="imageForm">

                    <div class="form-group">
                        <img class="img-responsive" ng-src="@{{ img.sizes[0].path  }}"/>

                        <i class="fa fa-remove" ng-click="ctrl.deleteImage(img)"></i>
                    </div>

                    <div class="form-group" ng-hide="!locale">
                        <input autocomplete="off" ng-change="ctrl.updateImage(img)" class="form-control" type="text" ng-model="img.translations[locale].title"/>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <div ng-class="{'col-md-6': limit == 1}">
        <form action="" class="dropzone" dropzone="dropzone" ng-show="!locked || limit == 1">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </form>
    </div>

</div>


