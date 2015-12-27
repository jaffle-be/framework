<div class="ibox">

    <div class="ibox-tabs">
        <uib-tabset justified="true">
            <uib-tab>
                <uib-tab-heading>
                    <i class="fa fa-camera"></i>
                </uib-tab-heading>
                <div class="ibox-content">

                    <image-input owner-type="'{{ $type }}'" owner-id="$state.params.id" locale="vm.options.locale"
                                 images="vm.{{ $model }}.images"></image-input>

                </div>
            </uib-tab>
            <uib-tab>
                <uib-tab-heading>
                    <i class="fa fa-video-camera"></i>
                </uib-tab-heading>
                <div class="ibox-content">

                    <video-input owner-type="'{{ $type }}'" owner-id="$state.params.id" locale="vm.options.locale"
                                 videos="vm.{{ $model }}.videos"></video-input>

                </div>
            </uib-tab>
            <uib-tab>
                <uib-tab-heading>
                    <i class="fa fa-info"></i>
                </uib-tab-heading>

                <div class="ibox-content">

                    <infographic-input owner-type="'{{ $type }}'" owner-id="$state.params.id" locale="vm.options.locale"
                                       infographics="vm.{{ $model }}.infographics"></infographic-input>

                </div>
            </uib-tab>

            <uib-tab>
                <uib-tab-heading>
                    <i class="fa fa-folder"></i>
                </uib-tab-heading>
                <div class="ibox-content">

                    <file-input owner-type="'{{ $type }}'" owner-id="$state.params.id" locale="vm.options.locale"
                                files="vm.{{ $model }}.files"></file-input>

                </div>
            </uib-tab>

        </uib-tabset>
    </div>

</div>

@include('media::admin.image')
@include('media::admin.video')
@include('media::admin.infographic')
@include('media::admin.file')
