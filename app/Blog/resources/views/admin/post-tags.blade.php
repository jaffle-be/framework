<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('blog::admin.post.tags') }}</h5>
    </div>

    <div class="ibox-content">

        <tag-input locale="vm.options.locale" owner-type="'blog'" owner-id="$state.params.id"></tag-input>

    </div>

</div>