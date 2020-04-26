{% extends 'layouts/base.volt' %}

{% block head %}
    {{ assets.outputCss('postCss') }}
{% endblock %}

{% block title %}{{ title }}{% endblock %}

{% block content %}
    <header class="masthead"
            style="background-image: url('{{ static_url('/img/georgiana-sparks-1KkjeJgtOxE-unsplash.jpg') }}')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>TCuit Blog</h1>
                        <span class="subheading">Simple Microblogging</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        {{ flash.output() }}
        <div class="row mx-2">
            <div class="col-6 mx-auto">
                <div class="card w-75 bg-dark text-white">
                    <div class="card-body">
                        <form action="{{ url('post/createPost') }}" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="titleArea">Title</label>
                                <input class="form-control" id="titleArea" name="title"/>
                            </div>
                            <div class="form-group">
                                <label for="contentArea">What's Happening?</label>
                                <textarea class="form-control" id="contentArea" name="content"
                                          maxlength="120"></textarea>
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary">Post!</button>
                            <small class="ml-3" style="font-size: small">Max. 120 Character.</small>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mx-2">
            <div class="col-6 mx-auto">
                <div class="post-preview">
                    {% for index, post in posts %}
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ url.get(links[index]) }}">
                                    <h4 class="post-title">
                                        {{ post.title }}
                                    </h4>
                                </a>
                                <p class="post-subtitle">
                                    {{ post.content }}
                                </p>
                                <small class="post-meta">Posted by
                                    <a href="#">{{ post.fullname }}</a>
                                    <small>{{ post.created_at }}</small></small>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-sm"
                                        id="replyButton" data-toggle="collapse"
                                        data-target="#replyForm">Reply
                                </button>

                                <div class="collapse" id="replyForm">
                                    <div class="card card-body">
                                        <form action="post/replyPost/{{ post.id }}" method="post">
                                            <div class="form-group">
                                                <label for="replyContent">Reply Something</label>
                                                <textarea maxlength="120" name="content" id="replyContent"
                                                          placeholder="What's on your mind?"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-secondary">Reply</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    {% endfor %}
                </div>
                <!-- Pager -->
                <div class="clearfix m-3">
                    <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
                </div>
            </div>
        </div>
    </div>

{% endblock %}

{% block js %}


{% endblock %}
