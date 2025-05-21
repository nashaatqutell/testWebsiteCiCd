<!doctype html>
<html lang="en">

@include('dashboard.partials.head')

<body class="vertical  light  @if (LaravelLocalization::getCurrentLocale() == 'ar') rtl @endif">
    <div class="wrapper">

        @include('dashboard.partials.navbar')

        @include('dashboard.partials.sidebar')

        <main role="main" class="main-content">
            @include('dashboard.partials.messages')
            @yield('content')
        </main>
    </div>

    @include('dashboard.partials.scripts')

    @yield('after_script')

</body>

</html>
