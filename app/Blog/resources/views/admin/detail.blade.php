<div class="row wrapper wrapper-content" ng-controller="BlogDetailController as vm" ng-init="vm.options = {{ system_options() }}">

    @include('system::admin.locale-tabs')

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

    <div class="col-xs-12 col-lg-7">

        @include('blog::admin.post-text')

    </div>

    <div class="col-xs-12 col-lg-5" ng-show="vm.post.id">

        @include('blog::admin.post-tags')

        @include('blog::admin.post-images')

    </div>

</div>