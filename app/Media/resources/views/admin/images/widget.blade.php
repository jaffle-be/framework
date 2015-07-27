<div class="input-image">

    <div class="loader" ng-show="!loaded">

        <div class="sk-spinner sk-spinner-double-bounce">
            <div class="sk-double-bounce1"></div>
            <div class="sk-double-bounce2"></div>
        </div>

    </div>

    <div class="row row-eq-height list">
        <div class="item col-md-6" ng-show="loaded" ng-repeat="img in images track by $index" ng-class="{clearfix: $index%2==0}">

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


<div class="clearfix"></div>

<form action="" class="dropzone" dropzone="dropzone">
    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
</form>