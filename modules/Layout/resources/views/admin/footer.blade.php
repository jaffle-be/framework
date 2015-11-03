<script type="text/ng-template" id="templates/admin/layout/footer">
    <div class="footer fixed">
        <div class="pull-right">
            {{ Lang::get('layout::admin.website-by') }}
            <strong>{{ str_replace('-' . env('APP_ENV'), '', env('APP_NAME')) }}</strong>
        </div>
        <div>
            <? $year = Carbon\Carbon::now()->format('Y') ?>

            @if($year != 2015)
                <strong>Copyright</strong> &copy; 2015-{{ $year }}
            @else
                <strong>Copyright</strong> &copy; 2015
            @endif
        </div>
    </div>

</script>