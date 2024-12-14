<!DOCTYPE html>
<html lang="en">

@include('includes.header')

<body>  
    <div id="wrapper">
            
        <div id="page-wrapper" class="gray-bg">
            @include('includes.navbar')
            @yield('content')
            @include('includes.footer')
        </div>
    </div>
    @include('includes.js')
</body>

</html>