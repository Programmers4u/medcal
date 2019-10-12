<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        @if (app()->environment('local'))
        <span class="pull-right">{!! Label::danger('LOCAL') !!}
            <span class="text-danger">&nbsp;{{ trans('app.footer.local') }}</span>
        </span>
        @endif
        @if (app()->environment('demo'))
        <span class="pull-right">{!! Label::danger('DEMO') !!}
            <span class="text-danger">&nbsp;{{ trans('app.footer.demo') }}</span>
        </span>
        @endif
    </div>
    <!-- Default to the left -->
    <strong>powered by people, wersja {{ env('APP_VERSION') }}</strong>
</footer>