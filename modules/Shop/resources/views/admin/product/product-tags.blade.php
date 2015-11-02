<div class="ibox">

    <div class="ibox-tabs">

        <tabset justified="true">

            <tab>

                <tab-heading>
                    <i class="fa fa-tag"></i>
                </tab-heading>

                <div class="ibox-content">

                    <tag-input locale="vm.options.locale" owner-type="'product'" owner-id="$state.params.id"></tag-input>

                </div>

            </tab>

            <tab>
                <tab-heading>
                    <i class="fa fa-search"></i>
                </tab-heading>

                <div class="ibox-content">

                    <seo-input locale="vm.options.locale" owner-type="'product'" owner-id="$state.params.id"></seo-input>

                </div>

            </tab>

        </tabset>

    </div>
</div>

@include('system::admin.seo')