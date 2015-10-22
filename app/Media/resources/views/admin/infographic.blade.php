<div>
    <form action="" class="dropzone" dropzone="dropzone" ng-show="!locked || limit == 1">
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    </form>
</div>

<div class="media-image-uploader">

    <div class="loader" ng-show="!loaded">

        <div class="sk-spinner sk-spinner-double-bounce">
            <div class="sk-double-bounce1"></div>
            <div class="sk-double-bounce2"></div>
        </div>

    </div>

    <div class="item" ng-show="loaded" ng-repeat="graphic in graphics[locale] track by $index">

        <form ng-submit="ctrl.updateInfographic(graphic)" novalidate name="graphicForm">

            <div class="media-image">
                <img class="img-responsive" ng-src="@{{ graphic.sizes[0].path  }}"/>

                <div class="tools">
                    <div class="tools-inner">
                        <span><i ng-show="($index != graphics[locale].length - 1)" ng-click="ctrl.moveDown(graphic, $index)" class="fa fa-arrow-down"></i></span>
                        <span><i ng-show="($index != 0)" ng-click="ctrl.moveUp(graphic, $index)" class="fa fa-arrow-up"></i></span>
                        <span><i class="fa fa-trash" ng-really="ctrl.deleteInfographic(graphic)"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-group" ng-hide="!locale">
                <input autocomplete="off" ng-change="ctrl.updateInfographic(graphic)" class="form-control" type="text" ng-model="graphic.title" placeholder="{{ Lang::get('media::admin.image-title') }}"/>
            </div>
        </form>

    </div>

    <div class="clearfix"></div>

</div>