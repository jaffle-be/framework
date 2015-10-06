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
            <tab heading="{{ Lang::get('blog::admin.post.infographic') }}">
                <div class="ibox-content">

                    <div class="alert alert-info">
                        images containing context should be uploaded here.
                        the difference with regular images would be
                        that the url is also a translatable attribute.
                        this would allow to show a different image when viewing in a different locale
                    </div>

                </div>
            </tab>

            <tab heading="{{ Lang::get('blog::admin.post.files') }}">
                <div class="ibox-content">

                    <div class="alert alert-info">
                        all other file types should be uploaded here.
                        The files should probably not be inlined into the article separatly.
                        It should instead add a list of all the files for the resource automatically
                    </div>

                </div>
            </tab>

        </tabset>
    </div>

</div>