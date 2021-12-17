<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        @yield('head')
        <title>@yield('title')</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> -->
        <!-- Bootstrap CSS -->
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito';
            }
            .preview {
                overflow: hidden;
                width: 160px; 
                height: 160px;
                margin: 10px;
                border: 1px solid red;
            }
            .my-img {
                display: block;
                max-width: 100%;
            }
            .modal { overflow: auto !important; }
        </style>

        <link rel="stylesheet" href="/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
    </head>
    
    <body class="antialiased bg-gray-100 dark:bg-gray-900">

        <!-- <nav class="navbar navbar-expand-lg navbar-mainbg">
            <a class="navbar-brand navbar-logo" href="#">Library</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-white"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <div class="hori-selector">
                        <div class="left"></div>
                        <div class="right"></div>
                    </div>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="javascript:void(0);"><i class="far fa-address-book"></i>Address Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);"><i class="far fa-clone"></i>Components</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);"><i class="far fa-calendar-alt"></i>Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);"><i class="far fa-chart-bar"></i>Charts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);"><i class="far fa-copy"></i>Documents</a>
                    </li>
                    <li class="nav-item">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-warning">Register</a>
                                @endif
                            @endauth
                        @endif
                    </li>
                </ul>
            </div>
        </nav> -->

        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/">
                <svg height="45" viewBox="0 0 58 58" width="45" xmlns="http://www.w3.org/2000/svg"><g id="Page-1" fill="none" fill-rule="evenodd"><g id="030---Messy-Books" fill-rule="nonzero"><path id="Shape" d="m5.72 52.21-5.55-31.51c-.05359011-.3041252-.08699643-.6114633-.1-.92-.08248096-3.5724087 2.48267266-6.6582757 6.01-7.23l10.71-1.89-.29 41.55z" fill="#35495e"/><path id="Shape" d="m46.94 50.83c-.1857191.771023-.8094746 1.3594717-1.59 1.5l-31.52 5.56c-1.9867206.3468301-4.02657856-.1786842-5.59841615-1.4422808-1.57183758-1.2635966-2.52340318-3.1428808-2.61158385-5.1577192-.07876599-3.4155632 2.27277316-6.4084312 5.61-7.14l8.83 2.48h-.01l-7.95 1.41c-.8866555.1558432-1.656734.7009972-2.0983662 1.4854753-.44163213.7844782-.50828985 1.7256321-.1816338 2.5645247.5656214 1.3511449 2.0021594 2.1195258 3.44 1.84l24.09-4.25z" fill="#2c3e50"/><path id="Shape" d="m20.05 46.63-7.95 1.41c-.8866555.1558432-1.656734.7009972-2.0983662 1.4854753-.44163213.7844782-.50828985 1.7256321-.1816338 2.5645247.5656214 1.3511449 2.0021594 2.1195258 3.44 1.84l24.09-4.25z" fill="#f9eab0"/><path id="Shape" d="m12.826 33.171 5.557-31.514c.1989194-1.08324679 1.2310871-1.80580869 2.317-1.622l31.277 5.515c3.5298611.57216709 6.0970156 3.66000793 6.015 7.235-.0136036.3071659-.0470063.6131344-.1.916l-5.557 31.514z" fill="#e64c3c"/><path id="Shape" d="m45.438 10.474c-.0586532-.0000276-.1171977-.0050457-.175-.015l-22.651-3.994c-.5111685-.12606546-.837041-.62687769-.7452297-1.14529488.0918113-.5184172.5698565-.87685619 1.0932297-.81970512l22.65 3.989c.5108329.08948831.8684834.55465053.8237134 1.07132656-.0447699.51667604-.4771014.91338644-.9957134.91367344z" fill="#3f5c6c"/><path id="Shape" d="m40.63 14.7c-.0587024.0000849-.1172863-.0052713-.175-.016l-14.772-2.601c-.5314773-.1077828-.8801906-.6195404-.7860712-1.1536068.0941194-.5340663.5967671-.8957872 1.1330712-.8153932l14.773 2.6c.5138125.0868279.8748237.55367.8296023 1.0728015-.0452214.5191314-.4815156.9165204-1.0026023.9131985z" fill="#3f5c6c"/><rect id="Rectangle-path" fill="#ecf0f1" height="12" rx="1" transform="matrix(.985 .174 -.174 .985 4.511 -5.088)" width="23" x="19.833" y="17.234"/><path id="Shape" d="m57.99 12.78c-.0119064.3086184-.0453208.6160308-.1.92l-5.56 31.51-7.71-2.35 4.47-25.34 1.06-5.98 1.08-6.12.75.13c3.5257169.57454224 6.0894162 3.6586597 6.01 7.23z" fill="#c03a2b"/><path id="Shape" d="m46.42 37.06-31.28-5.51c-.1156046-.0199087-.2326936-.0299449-.35-.03-1.0364668.0026285-1.8991916.7966438-1.9876335 1.8293337-.088442 1.0326898.6267071 1.9618379 1.6476335 2.1406663l31.51 5.55c.8858791.1604248 1.6536061.708589 2.0929592 1.4943923.439353.7858033.5042941 1.7269044.1770408 2.5656077-.5625614 1.3481553-1.9969395 2.1134358-3.43 1.83l-31.39-5.53c-.1156046-.0199087-.2326936-.0299449-.35-.03-1.0383851-.0025575-1.9060067.7899765-1.9971986 1.8243528-.0911918 1.0343762.624383 1.9664868 1.6471986 2.1456472l31.52 5.55c1.9852737.3480364 4.0242759-.1756778 5.5960992-1.4373484 1.5718232-1.2616705 2.5242277-3.1390976 2.6139008-5.1526516.0784876-3.576507-2.4892143-6.6645738-6.02-7.24z" fill="#802f34"/><path id="Shape" d="m48.23 45.1c-.5625614 1.3481553-1.9969395 2.1134358-3.43 1.83l-31.39-5.53 1.04-5.91 31.51 5.55c.8858791.1604248 1.6536061.708589 2.0929592 1.4943923.439353.7858033.5042941 1.7269044.1770408 2.5656077z" fill="#f9eab0"/></g></g></svg>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

            @if (Route::has('login'))

                <ul class="navbar-nav mr-auto">
                
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home<span class="sr-only">(current)</span></a>
                    </li>

                    @auth

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Master</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/buku">Buku</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/member">Member</a>
                                <a class="dropdown-item" href="/member/category">Category</a>
                            </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transaction</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/pinjam">Peminjaman</a>
                                <a class="dropdown-item" href="/kembali">Pengembalian</a>
                            </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Report</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/pinjam/report">Peminjaman</a>
                                <a class="dropdown-item" href="/kas/report">Kas</a>
                            </div>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Link Mati</a>
                    </li> -->
                    <li class="nav-item">
                        <a id="navCropper" class="nav-link invisible" href="/cropper">Cropper</a>
                    </li>
                </ul>

                <button id="btnCart" class="btn btn-outline-primary" onclick="location.href='/pinjam'"><i class="fas fa-shopping-cart"></i> <span class="badge badge-pill badge-primary countcart"></span></button>
                &nbsp;
                <a href="{{ url('/user/profile') }}" class="btn btn-primary mr-2">Dashboard</a>

                @else
                </ul>
                    <!-- <span class="navbar-text mr-3">Silahkan login atau register</span> -->
                    <span class="navbar-text mr-3">Silahkan login</span>
                    <a href="{{ route('login') }}" class="btn btn-outline-success mr-2">Login</a>
                    @if (Route::has('register'))
                        <!-- <a href="{{ route('register') }}" class="btn btn-outline-danger">Register</a> -->
                    @endif
                @endauth
            @endif

            </div>

        </nav>
<!-- Navbar fixed-top jadi <br> nya banyak -->
<br>
<br>
<br>
<br>
        <!-- Saya tambahin <br> di atas ini!, <body class="bg-gray-100 dark:bg-gray-900">, dan di bawah gak pake class="flex sm:items-center" -->
        <!-- <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"> -->
        <div class="relative items-top justify-center min-h-screen sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <!-- bagian konten blog -->
                    @yield('konten')
                </div>

                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                    <p>@Copyright Rizal Andriana 2021</p>
                </div>
            </div>
        </div>

        <!-- Modal untuk Cropper -->
        <div class="modal fade" id="modalCropper" tabindex="-1" role="dialog" aria-labelledby="modalCropperTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div id="divCropper">
                    </div>
                </div>
            </div>
        </div>

        @yield('modal')

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
        <script src="/js/jquery.js"></script>
        <script src="/js/popper.js"></script> 
        <script src="/js/bootstrap.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
        <!-- Link: https://sweetalert2.github.io/ -->
        @yield('script')
        <script>
            $(document).ready( function () {
                countcart();
            });

            function countcart() {
                $.ajax({
                    url: '/countcart',
                    type: 'GET',
                    data: {'_token': $('meta[name="_token"]').attr('content')},
                    ajaxasync: true,
                    success: function (data) {    
                        console.log(data['countcart']);
                        if (data['countcart'] == 0) {
                            $('.countcart').text('');
                        }
                        else {
                            $('.countcart').text(data['countcart']);
                        }
                    },
                    failure: function (data) {
                        console.log(data.responseText);
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            };

            $('body').on('click', '#navCropper', function (event) {
                event.preventDefault();
                var route = '/cropper';
                $('#divCropper').load(route);
                $('#modalCropper').modal('show');
            });
        </script>
    </body>
</html>