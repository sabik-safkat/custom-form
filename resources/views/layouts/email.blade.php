<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <style>
        
    </style>


@yield('custom_css')

<head>
    
</head>
<body>

    <div style="text-align:center;">
        <div style="display: inline-block; text-align:left;">    
            @yield('content')

            <hr>

            <div>

            </div>

            <footer style="text-align: center;">
                <p class="copyright_area">&copy; {{date('Y')}} crofun.jp</p>
            </footer>
        </div>

        
    </div>      
    @yield('custom_js')
</body>
</html>
