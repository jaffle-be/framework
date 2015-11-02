<div class="ibox">

    <div class="ibox-tabs">
        <tabset justified="true">
            <tab>
                <tab-heading>
                    <i class="fa fa-camera"></i>
                </tab-heading>
                <div class="ibox-content">

                    <image-input owner-type="'{{ $type }}'" owner-id="$state.params.id" locale="vm.options.locale"></image-input>

                </div>
            </tab>
            <tab>
                <tab-heading>
                    <i class="fa fa-video-camera"></i>
                </tab-heading>
                <div class="ibox-content">

                    <video-input owner-type="'{{ $type }}'" owner-id="$state.params.id" locale="vm.options.locale"></video-input>

                </div>
            </tab>
            <tab>
                <tab-heading>
                    <i class="fa fa-info"></i>
                </tab-heading>

                <div class="ibox-content">

                    <infographic-input owner-type="'{{ $type }}'" owner-id="$state.params.id" locale="vm.options.locale"></infographic-input>

                </div>
            </tab>

            <tab>
                <tab-heading>
                    <i class="fa fa-folder"></i>
                </tab-heading>
                <div class="ibox-content">

                    <file-input owner-type="'{{ $type }}'" owner-id="$state.params.id" locale="vm.options.locale"></file-input>

                </div>
            </tab>

        </tabset>
    </div>

</div>

@include('media::admin.image')
@include('media::admin.video')
@include('media::admin.infographic')
@include('media::admin.file')