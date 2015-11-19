TaphaBlogBundle Upgrade from <= 1.2.1
============

###1)  Change in app routing.yml

Change

    tapha_blog:
        resource: "@TaphaBlogBundle/Resources/config/routing.yml"

By

    tapha_blog:
        resource: "@TaphaBlogBundle/Resources/config/routing.yml"
        prefix: /blog

Add

    tapha_blog_admin:
        resource: "@TaphaBlogBundle/Resources/config/routing_admin.yml"
        prefix: /badp

###2)  For dev only, add in app routing_dev.yml

    tapha_blog_secure:
        resource: "@TaphaBlogBundle/Resources/config/routing_dev.yml"
        prefix: /badp

that's all (I think)