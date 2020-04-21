<!DOCTYPE html>
<html>
    <head>
        {% block head %}
            <link rel='stylesheet' href='style.css' />
        {% endblock %}

        <title>{% block title %}{% endblock %} - My Webpage</title>
    </head>

    <body>
        <div class="container-fluid" id='content'>{% block content %}{% endblock %}</div>

        <div id='footer'>
            {% block footer %}
                &copy; Copyright 2020.
                All rights reserved.
            {% endblock %}
        </div>
    </body>
</html>
