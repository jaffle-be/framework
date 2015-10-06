<div class="ibox">

    <div class="ibox-tabs">
        <tabset>
            <tab heading="{{ Lang::get('blog::admin.post.images') }}">
                <div class="ibox-content">

                    <image-input owner-type="'blog'" owner-id="$state.params.id" locale="vm.options.locale"></image-input>

                </div>
            </tab>
            <tab heading="{{ Lang::get('blog::admin.post.videos') }}">
                <div class="ibox-content">

                    <video-input owner-type="'blog'" owner-id="$state.params.id" locale="vm.options.locale"></video-input>

                </div>
            </tab>
            <tab heading="{{ Lang::get('blog::admin.post.files') }}">
                <div class="ibox-content">

                    test 2

                </div>
            </tab>
        </tabset>
    </div>

</div>