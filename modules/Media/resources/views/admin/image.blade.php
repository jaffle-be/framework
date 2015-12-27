<script type="text/ng-template" id="templates/admin/media/image/widget">
    <div ng-class="{'col-md-6': limit == 1}">
        <form action="" class="dropzone" dropzone="dropzone" ng-show="!locked || limit == 1">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </form>
    </div>

    <div class="media-image-uploader" ng-class="{'col-md-6': limit == 1}">

        <div class="loader" ng-show="!loaded">

            <div class="sk-spinner sk-spinner-double-bounce">
                <div class="sk-double-bounce1"></div>
                <div class="sk-double-bounce2"></div>
            </div>

        </div>

        <div class="item" ng-show="loaded" ng-repeat="img in images track by $index">

            <form ng-submit="vm.updateImage(img)" novalidate name="imageForm">

                <div class="media-image">
                    <img class="img-responsive" ng-src="@{{ img.sizes[0].path  }}"/>

                    <div class="tools">
                        <div class="tools-inner">
                            <span><i ng-show="($index != images.length - 1)" ng-click="vm.moveDown(img, $index)"
                                     class="fa fa-arrow-down"></i></span>
                            <span><i ng-show="($index != 0)" ng-click="vm.moveUp(img, $index)"
                                     class="fa fa-arrow-up"></i></span>
                            <span><i class="fa fa-trash" ng-really="vm.deleteImage(img)"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group" ng-hide="!locale">
                    <input autocomplete="off" ng-change="vm.updateImage(img)" class="form-control" type="text"
                           ng-model="img.translations[locale].title"
                           placeholder="{{ Lang::get('media::admin.image-title') }}"/>
                </div>
            </form>

        </div>

        <div class="clearfix"></div>

    </div>
</script>
