<div class="ibox">

    <div class="ibox-tabs">

        <tabset>

            <tab heading="{{ Lang::get('blog::admin.post.tags') }}">

                <div class="ibox-content">

                    <tag-input locale="vm.options.locale" owner-type="'blog'" owner-id="$state.params.id"></tag-input>

                </div>

            </tab>

            <tab heading="{{ Lang::get('blog::admin.post.categories') }}">

                <div class="ibox-content">

                    <tag-input locale="vm.options.locale" owner-type="'blog'" owner-id="$state.params.id"></tag-input>

                </div>

            </tab>


            <tab heading="{{ Lang::get('blog::admin.post.links') }}">

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

            </tab>


            <tab heading="{{ Lang::get('blog::admin.post.seo') }}">

                <div class="ibox-content">
                    <div class="alert alert-info">
                        should display the input boxes like we have in wordpress yoast.
                        start with a very simple version...
                    </div>
                </div>

            </tab>




        </tabset>

    </div>



</div>