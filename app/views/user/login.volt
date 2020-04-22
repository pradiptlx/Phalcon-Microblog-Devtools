{% extends 'layouts/base.volt' %}

{% block title %}{{title}}{% endblock %}

{% block head %}
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/css/login/util.css">
    <link rel="stylesheet" type="text/css" href="/css/login/main.css">
{% endblock %}

{% block content %}

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form">
					<span class="login100-form-title p-b-34">
						Account Login
					</span>

                    <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user name">
                        <input id="first-name" class="input100" type="text" name="username" placeholder="User name">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
                        <input class="input100" type="password" name="pass" placeholder="Password">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Sign in
                        </button>
                    </div>

                    <div class="w-full text-center p-t-27 p-b-239">
						<span class="txt1">
							Forgot
						</span>

                        <a href="#" class="txt2">
                            User name / password?
                        </a>
                    </div>

                    <div class="w-full text-center">
                        <a href="#" class="txt3">
                            Sign Up
                        </a>
                    </div>
                </form>

                <div class="login100-more" style="background-image: url('/img/georgiana-sparks-1KkjeJgtOxE-unsplash.jpg');"></div>
            </div>
        </div>
    </div>

{% endblock %}

{% block js %}
    <script src="/vendor/select2/select2.min.js"></script>
    <script>
        $(".selection-2").select2({
            minimumResultsForSearch: 20,
            dropdownParent: $('#dropDownSelect1')
        });
    </script>
    <script src="/vendor/animsition/js/animsition.min.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="/vendor/daterangepicker/moment.min.js"></script>
    <script src="/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="/js/login/main.js"></script>

{% endblock %}
