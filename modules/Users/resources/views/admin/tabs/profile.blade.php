<div class="row">

    <div class="col-md-6">
        <div class="ibox">

            <div class="ibox-title">
                <h5>{{ Lang::get('users::admin.profile.basic-info') }}</h5>
            </div>

            <div class="ibox-content">

                @include('users::admin.elements.profile')

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div address-input address-id="{{ $user->address ? $user->address->id : null }}"
             address-owner-type="'user'"
             address-owner-id="{{ $user->id }}"></div>

    </div>

</div>

<div social-links-input owner-id="{{ $user->id }}" owner-type="'user'"></div>
