<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {% block head %}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">

        {% endblock %}
        <title>{% block title %}{% endblock %} - My Webpage</title>
    </head>


<body>
<div class="container-fluid m-4">
    {% include 'layouts/navbar.volt' %}
</div>

<div class="container-fluid" id='content'>{% block content %}{% endblock %}</div>

{#        <div id='footer'>#}
{#            {% block footer %}#}
{#                &copy; Copyright 2020.#}
{#                All rights reserved.#}
{#            {% endblock %}#}
{#        </div>#}



{% block js %}
{% endblock %}
</body>
</html>
