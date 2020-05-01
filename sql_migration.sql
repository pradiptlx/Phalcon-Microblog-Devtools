create table files_manager
(
    id        uniqueidentifier not null
        constraint files_manager_pk
            primary key nonclustered,
    file_name varchar(max)     not null,
    path      nvarchar(max)    not null,
    post_id   nvarchar(max)    not null
)
go

create table posts
(
    id               uniqueidentifier not null
        constraint posts_pk
            primary key nonclustered,
    title            varchar(150)     not null,
    content          nvarchar(max),
    repost_counter   int default 0    not null,
    created_at       datetime         not null,
    updated_at       datetime,
    user_id          nvarchar(max)    not null,
    share_counter    int default 0    not null,
    previous_post_id varchar(1)
)
go

create table reply_post
(
    id         uniqueidentifier not null
        constraint reply_post_pk
            primary key nonclustered,
    content    nvarchar(max),
    post_id    varchar(max)     not null,
    user_id    varchar(max)     not null,
    created_at datetime         not null,
    updated_at datetime
)
go

create table roles
(
    id          uniqueidentifier not null
        constraint roles_pk
            primary key nonclustered,
    role_name   varchar(50)      not null,
    permissions varchar(max)
)
go

create unique index roles_id_uindex
    on roles (id)
go

create unique index roles_role_name_uindex
    on roles (role_name)
go

create table stats_posts
(
    id              uniqueidentifier not null
        constraint stats_post_pk
            primary key nonclustered,
    post_id         nvarchar(max)    not null,
    reblog_counter  int default 0    not null,
    comment_counter int default 0    not null
)
go

create table users
(
    id         uniqueidentifier not null
        constraint users_pk
            primary key nonclustered,
    username   varchar(50)      not null,
    fullname   varchar(50),
    email      varchar(50)      not null,
    password   nvarchar(max)    not null,
    role_id    nvarchar(max)    not null,
    created_at datetime         not null,
    updated_at datetime
)
go

create unique index users_email_uindex
    on users (email)
go

create unique index users_username_uindex
    on users (username)
go


