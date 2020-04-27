{% extends 'layouts/base.volt' %}

{% block head %}
    {{ assets.outputCss('postCss') }}
{% endblock %}

{% block title %}{{ title }}{% endblock %}

{% block content %}
    {% if files is defined %}
        <header class="masthead" style="background-image: url("{{ static_url(file.path) }}")">
    {% else %}
        <header class="masthead">
    {% endif %}
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
                <div class="col-6 my-3 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <p>{{ post.content }}</p>
                        </div>
                    </div>
                </div>
            </div>


            {% if replies is defined %}
                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="card">
                            <div class="card-header">Reply</div>
                            <div class="card-body">
                                {% for reply in replies %}
                                    <div class="card">
                                        <div class="card-body">
                                            {{ reply.RepContent }}
                                        </div>
                                        <div class="card-footer">
                                            <small> By: {{ reply.RepFullname }} at {{ reply.RepCreatedAt }}</small>
                                            <button type="button" class="float-right btn btn-sm"
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
                                                        <button type="submit"
                                                                class="btn btn-sm btn-secondary"
                                                        >Reply
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {% endfor %}
                            </div>
                        </div>
                    </div>
                </div>
            {% endif %}
        </div>
    </article>





{% endblock %}
