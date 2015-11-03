<script type="text/ng-template" id="templates/admin/media/file/widget">
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

        <ul class="nav files" ng-show="loaded" as-sortable="vm.sortables" ng-model="dupes[locale]">
            <li ng-repeat="file in dupes[locale]" as-sortable-item class="item">

                <div class="form-group">
                    <label>{{ Lang::get('media::admin.filename') }}</label>

                    <span ng-bind="file.filename"></span>
                </div>

                <div class="form-group">

                    <div class="input-group" ng-hide="!locale">
                        <div class="input-group-addon" as-sortable-item-handle><i class="fa fa-arrows"></i></div>
                        <input autocomplete="off" ng-change="vm.updateFile(file)" class="form-control" type="text" ng-model="file.title" placeholder="{{ Lang::get('media::admin.title') }}"/>

                        <div class="input-group-btn">
                            <button class="btn btn-danger" ng-really="vm.deleteFile(file)"><i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </li>
        </ul>

        <div class="clearfix"></div>

    </div>
</script>