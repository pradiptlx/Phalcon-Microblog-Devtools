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
                        <h1>Microblog Blog</h1>
                        <span class="subheading">Simple Microblogging</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        {{ flash.output() }}
        <div class="row">
            <div class="col-6 mx-auto">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <form action="{{ url('post/createPost') }}" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="titleArea">Title</label>
                                <input class="form-control" id="titleArea" name="title"/>
                            </div>
                            <div class="form-group">
                                <label for="contentArea">What's Happening?</label>
                                <textarea class="form-control" id="contentArea" name="content" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Post!</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="row m-3">
            <div class="col-6 col-md-10 mx-auto">
                <div class="post-preview">
                    {% for index, post in posts %}
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ url.get(links[index]) }}">
                                    <h2 class="post-title">
                                        {{ post.title }}
                                    </h2>
                                    <h3 class="post-subtitle">
                                        {{ post.content }}
                                    </h3>
                                </a>
                                <p class="post-meta">Posted by
                                    <a href="#">Start Bootstrap</a>
                                    <small>{{ post.created_at }}</small></p>
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
