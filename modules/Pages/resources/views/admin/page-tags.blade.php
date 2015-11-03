<div class="ibox">

    <div class="ibox-tabs">

        <uib-tabset justified="true">

            @include('pages::admin.page-subpages')

            <uib-tab>
                <uib-tab-heading>
                    <i class="fa fa-link"></i>
                </uib-tab-heading>

                <div class="ibox-content">

                    <div class="alert alert-info">
                        this will hold a widget to add links to the content.
                        whenever a resource is deleted, the link should be deleted too.
                        <strong>warning:</strong> we will have to take care of deleting the 'link' shortcode
                        in the content. or our links will not render at the correct spot.

                        example:

                        if we have 3 links in an article
                        and we delete the first...
                        then both the second and last link, will both move up a spot in the article..
                        so they appear in a context that is no longer correct.
                    </div>

                </div>

            </uib-tab>


            <uib-tab>
                <uib-tab-heading>
                    <i class="fa fa-search"></i>
                </uib-tab-heading>

                <div class="ibox-content">

                    <seo-input locale="vm.options.locale" owner-type="'pages'" owner-id="$state.params.id"></seo-input>

                </div>

            </uib-tab>




        </uib-tabset>

    </div>

</div>

@include('system::admin.seo')