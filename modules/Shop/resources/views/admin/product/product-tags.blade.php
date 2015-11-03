<div class="ibox">

    <div class="ibox-tabs">

        <uib-tabset justified="true">

            <uib-tab>

                <uib-tab-heading>
                    <i class="fa fa-tag"></i>
                </uib-tab-heading>

                <div class="ibox-content">

                    <tag-input locale="vm.options.locale" owner-type="'product'" owner-id="$state.params.id"></tag-input>

                </div>

            </uib-tab>

            <uib-tab>
                <uib-tab-heading>
                    <i class="fa fa-search"></i>
                </uib-tab-heading>

                <div class="ibox-content">

                    <seo-input locale="vm.options.locale" owner-type="'product'" owner-id="$state.params.id"></seo-input>

                </div>

            </uib-tab>

        </uib-tabset>

    </div>
</div>

@include('system::admin.seo')