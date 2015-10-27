<div>

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Alpha project</h5>

                <div ibox-tools></div>
            </div>
            <div class="ibox-content">
                <form novalidate ng-submit="vm.update(user)" class="form-horizontal">

                    <div class="form-group">
                        <label for="name">naam</label>
                        <input class="form-control" type="text" name="name" ng-model="user.name"/>
                    </div>

                    <div class="form-group">
                        <label for="movie">film</label>
                        <input class="form-control" type="text" name="movie" ng-model="user.movie"/>
                    </div>

                    <p class="text-center">
                        <input class="btn btn-submit" type="submit"/>
                    </p>

                </form>
            </div>
        </div>

    </div>

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Alpha project</h5>

                <div ibox-tools></div>
            </div>
            <div class="ibox-content">
                @{{ user.name }}

                @{{ user.movie }}
            </div>
        </div>

    </div>

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Alpha project</h5>

                <div ibox-tools></div>
            </div>
            <div class="ibox-content">
                @{{ vm.response }}
            </div>
        </div>

    </div>

</div>

