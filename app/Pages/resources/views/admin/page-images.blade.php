<div class="ibox">

    <div class="ibox-tabs">
        <tabset>
            <tab heading="{{ Lang::get('pages::admin.page.images') }}">
                <div class="ibox-content">

                    <image-input owner-type="'pages'" owner-id="$state.params.id" locale="vm.options.locale"></image-input>

                </div>
            </tab>
            <tab heading="{{ Lang::get('pages::admin.page.videos') }}">
                <div class="ibox-content">

                    <video-input owner-type="'pages'" owner-id="$state.params.id" locale="vm.options.locale"></video-input>

                </div>
            </tab>
            <tab heading="{{ Lang::get('pages::admin.page.infographic') }}">
                <div class="ibox-content">

                    <infographic-input owner-type="'pages'" owner-id="$state.params.id" locale="vm.options.locale"></infographic-input>

                </div>
            </tab>

            <tab heading="{{ Lang::get('pages::admin.page.files') }}">
                <div class="ibox-content">

                    <file-input owner-type="'pages'" owner-id="$state.params.id" locale="vm.options.locale"></file-input>

                </div>
            </tab>

        </tabset>
    </div>

</div>