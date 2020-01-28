<li id='search-bar-menu'>
    {!! Form::open(['method' => 'post', 'url' => route('manager.search', $business), 'class' => 'navbar-form navbar-left', 'role' => 'search']) !!}
    <div class="form-group">
        <input id="search" style="border-radius: 4px;" name="criteria" type="text" class="form-control" placeholder="{{trans('app.search.placeholder')}}">
        <span class="form-group">
            <button type="submit" style="border-radius: 4px;"  name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
        </span>
    </div>
    {!! Form::close() !!}
</li>

<style>
    @media all and (min-width: 500px) {
        #search-bar-menu {
            display: block;
        };
    };
    #search-bar-menu {
        display: none !important;
    };
</style>