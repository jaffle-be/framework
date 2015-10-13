<div class="row wrapper-content" ng-controller="BlogDetailController as vm" ng-init="vm.options = {{ system_options() }}">

    @include('system::admin.locale-tabs')

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">

            @include('blog::admin.post-text')

        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3" ng-show="vm.post.id">

            @include('blog::admin.post-tags')

            @include('blog::admin.post-images')

        </div>
    </div>

    {{--<div class="col-xs-12">

        <div class="alert alert-danger">
            <div class="title">Drafting</div>
            <p>
                drafting should be enabled by pressing a user button.
                the server should then create a new draft document.
                this should clone all tags etc to the draft document.
                the draft itself should be tied to the original document.

                upon publishing the draft will overwrite the original one completely
                (except for maybe some original fields like the created timestamp)
            </p>
        </div>

    </div>--}}

</div>