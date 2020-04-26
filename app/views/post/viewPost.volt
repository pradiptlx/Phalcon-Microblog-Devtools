{% extends 'layouts/base.volt' %}

{% block head %}
    {{ assets.outputCss('postCss') }}
{% endblock %}

{% block title %}{{ title }}{% endblock %}

{% block content %}
    <header class="masthead" style="background-image: url('img/post-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="post-heading">
                        <h1>{{ post.title }}</h1>
{#                        <h2 class="subheading">Problems look mighty small from 150 miles up</h2>#}
                        <span class="meta">Posted by
              <a href="#">{{ post.fullname }}</a>
              on {{ post.created_at }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <p>{{ post.content }}</p>
                </div>
            </div>
        </div>
    </article>



{% endblock %}
