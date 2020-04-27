{% extends 'layouts/base.volt' %}

{% block head %}
    {{ assets.outputCss('dashboardCss') }}
{% endblock %}

{% block title %}{{ title }}{% endblock %}

{% block content %}

    <div class="container">
        <div class="row profile">
            <div class="col-md-3">
                <div class="profile-sidebar">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <img src="{{ static_url('/img/profilepic.jpg') }}"
                             class="img-responsive float-none" alt="">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            {{ user.fullname }}
                        </div>
                        <div class="profile-usertitle-job">
                            @{{ user.username }}
                        </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <div class="profile-userbuttons">
                        {% if self === true %}
                            <button type="button" href="{{ url('/user/logout') }}" class="btn btn-success btn-sm">Logout</button>
                            <button type="button" class="btn btn-danger btn-sm"
                                    data-toggle="modal" data-target="#resetPassModal">Change Password
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="resetPassModal" data-backdrop="static" tabindex="-1"
                                 role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ url('/user/resetPassword') }}" method="post">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Reset Password</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <label for="inputOldPassword">Old Password</label>
                                                    <input type="password" id="inputOldPassword"
                                                           name="oldPassword">
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputNewPassword">New Password</label>
                                                    <input type="password" id="inputNewPassword"
                                                           name="newPassword">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        {% else %}
                            <button type="button" class="btn btn-success btn-sm">Follow</button>
                            <button type="button" class="btn btn-danger btn-sm">Message</button>
                        {% endif %}
                    </div>
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-home"></i>
                                    Overview
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-user-circle"></i>
                                    Account Settings
                                </a>
                            </li>

                            {#<li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-list-ul"></i>
                                    Post
                                </a>
                            </li>#}
                        </ul>
                    </div>
                    <!-- END MENU -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="profile-content">
                    {% for post in posts %}

                        <div class="card my-3 no-gutters" id="userPost">
                            <div class="card-header">
                                <a href="{{ url('/post/viewPost/'~post.id) }}">
                                    {{ post.title }}
                                </a>
                            </div>
                            <div class="card-body">
                                {{ post.content }}
                            </div>
                        </div>

                    {% endfor %}
                </div>
            </div>
        </div>
    </div>

{% endblock %}
