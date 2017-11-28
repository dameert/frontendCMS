
Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require dameert/frontend-cms
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project (also enable Assetic):

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Dameert\FrontendCms\DameertFrontendCmsBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3. Configure assetic
-------------------------
```yml
# app/config/config.yml
assetic:
    debug:          '%kernel.debug%'
    use_controller: '%kernel.debug%'
    filters:
        cssrewrite: ~
```

For more information, see [assetic documentation](http://symfony.com/doc/current/frontend/assetic/asset_management.html)

Step 4. Configure the bundle
---------------------------
```yml
# app/config/config.yml
dameert_frontend_cms:
    content_path: '%content_path%'
    template_path: '%template_path%'
```

- content_path: the folder containing the json files which represent the contents of your website.
- template_path: the folder containing the templates that represent your different content types.

Step 5. Configure Routing
-------------------------
```yml
# app/config/routing.yml
dameert_frontend_cms:
    resource: '@DameertFrontendCmsBundle/Controller/'
    type: annotation
```

Step 6. Add Security
--------------------
In order to edit content via the frontend, the role `'ROLE_FRONTEND_ADMIN'` is required. The bundle comes with a predefined User object that can be used for this.

For a quick setup you can use the following configuration:
```yml
# app/config/security.yml
security:
    providers:
        database_provider:
            entity:
                class: Dameert\FrontendCms\Entity\User

    encoders:
            Dameert\FrontendCms\Entity\User:
                algorithm: bcrypt
                cost: 12
    
    firewalls:
        # disables authentication for assets and the profiler, adapt it according to your needs
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        main:
            anonymous: ~
            http_basic: ~
            provider: database_provider
            logout:
                path:   /logout
                target: /

    access_control:
        # require ROLE_FRONTEND_ADMIN for /admin*
        - { path: ^/admin, roles: ROLE_FRONTEND_ADMIN }
```

Make sure to configure your database:
```yml
#app/config/config.yml
doctrine:
    dbal:
        driver: pdo_sqlite
        charset: UTF8
        path: '%database_path%'

    orm:
        auto_generate_proxy_classes: '%kernel.debug%'
        naming_strategy: doctrine.orm.naming_strategy.underscore
        auto_mapping: true
```

To create the database execute in console:

```console
php bin/console d:d:c
php bin/console d:s:u --force
```

Todo: create first user and admin interface. For now add your user manually in the database and [use symfony to encode your password](https://symfony.com/doc/current/security.html#c-encoding-the-user-s-password)

Step 7. Dump your assets for production environment
---------------------------------------------------
```console
php bin/console assetic:dump --env=prod --no-debug
```

This should create the following two files:

- `app/../web/css/frontend-editor-compiled.css`
- `app/../web/js/frontend-editor-compiled.js`

Step 7. Integration
-------------------
To integrate the frontend editor in your project you have 2 options:
1. Extend the `base.html.twig template` provided by the bundle.
2. Integrate `/web/css/frontend-editor-compiled.css` and `/web/js/frontend-editor-compiled.js` in your own templates.
When you go for your own implementation, make sure to use `{{ ajaxSavePath() }}` in your body tag:
```twig
{% extends 'DameertFrontendEditorBundle::base.html.twig' %}

...

<body {{ frontendEditorAttributes(type) }}>

..
{% include 'DameertFrontendEditorBundle::js.html.twig' %}
```

```
//Todo break this part down in subsections:
//Twig layout
//Defining content types
//Defining content data
//Including the frontend edition (editor & metadata)
//Access json stored data in twig
```
