<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="/vendor/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="/clinic_icon.png" type="image/x-icon">
        <style>
            .divider:after,
            .divider:before {
                content: "";
                flex: 1;
                height: 1px;
                background: #eee;
            }
            .bg{
                /* background-image: url('/img/industrial_background.jpg'); */
                background-position: center center;
                background-repeat: no-repeat;
                background-size:cover;
                /* filter: blur(8px);
                -webkit-filter: blur(8px); */
                width: 100vw;
                height: 100vh;
            }
            .bg-b{
                background-color: rgba(0, 0, 0, 0.8);
            }
            .bg-b2{
                background-color: rgba(0, 0, 0, 0.8);
                border-radius: 20px;
                color:rgb(200, 200, 200);
            }
        </style>
    </head>
    <body class="bg">
        <div class="bg-b w-100 h-100 d-flex justify-content-center align-items-center">

            <div class="bg-b2 pt-5 pb-5 ps-4 pe-4" style="width:360px">

                <div class="form-outline mb-4">
                    {{-- <img src="/img/logo.png" class="w-100"> --}}
                </div>
                <form method="POST" action="{{ route('login') }}"> @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form1Example13">NIP</label>
                        <input type="text" name="nip" id="form1Example13" class="form-control form-control-md" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form1Example23">Password</label>
                        <input type="password" name="password" id="form1Example23" class="form-control form-control-md" />
                    </div>

                    <button type="submit" class="btn btn-primary btn-md btn-block w-100">Login</button>
                </form>
            </div>
        </div>
        {{-- <section class="vh-100 vw-100 bg-b">
            <div class="container w-100 h-100" style="color:white">
                <div class="row d-flex align-items-center justify-content-center h-100 w-100">


                </div>
            </div>
        </section> --}}

        <script src="/vendor/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
