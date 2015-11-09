<div class="row">

    <div ng-switch on="widget.manual">

        <div ng-switch-when="true">
            <div class="col-xs-6">
                <div>
                    <img ng-src="{{ vm.showImage(widget.image) }}" class="img-responsive">
                </div>
            </div>

            <div class="col-xs-6">
                <div>
                    <img ng-src="{{ vm.showImage(widget.image) }}" class="img-responsive">
                </div>
            </div>

        </div>

        <div ng-switch-when="false">
            <div class="col-xs-6">
                <div>
                    <img ng-src="{{ vm.showResourceImage('one', widget) }}" class="img-responsive">
                </div>
            </div>

            <div class="col-xs-6">
                <div>
                    <img ng-src="{{ vm.showResourceImage('two', widget) }}" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
</div>