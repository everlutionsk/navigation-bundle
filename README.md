# Everlution Navigation bundle

## Installation

### Step 1: Download the Bundle


```console
$ composer require everlutionsk/navigation-bundle
```

### Step 2: Enable the Bundle

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

            new Everlution\NavigationBundle\EverlutionNavigationBundle(),
        );

        // ...
    }

    // ...
}
```

## Configuration

Where will be the navigation definitions loaded from:

```yaml
everlution_navigation:
    yaml_dir: '%kernel.root_dir%/config/navigation' # this is default value
```


## Usage

You can create either dynamic navigations by extending `Everlution\Navigation\Provider\NavigationProvider`
and registering it within container as tagged service:

```yaml
app.navigation.your_navigation:
    class: Path\To\Your\Provider
    tags:
        - { name: everlution.navigation_provider }
```

OR

You can define your navigation within YAML file:

```yaml
# app/config/navigation/frontend.yml
items:
    -
        class: Everlution\Navigation\Item\Url
        label: "Home"
        url: "/"
    -
        class: Everlution\Navigation\Item\Url
        label: "E-shop"
        url: "/eshop"
        attributes:
           class: "dropdown-btn"
           image: "image.png"
           image_alt: "An image"
           image_class: "profile-image"
           icon_class: "material-icons right"
           icon_content: "arrow_drop_down"
           dropdown_id: "dropdown-top-nav"
        children: # multi-level navigation
            -
                class: Everlution\Navigation\Item\Url
                label: "First category"
                url:  "/eshop/first-category"
                children:
                    -
                        class: Everlution\Navigation\Item\Url
                        label: "Subcategory"
                        url: "/eshop/first-category/subcategory"
            -
                class: Everlution\Navigation\Item\Route
                label: "Second category"
                route: "eshop_second_category"
                children:
                    -
                        class: Everlution\Navigation\Item\Url
                        label: "First subcategory"
                        url: "/eshop/second-category/first-subcategory"
                    -
                        class: Everlution\Navigation\Item\Url
                        label: "Second subcategory"
                        url: "/eshop/second-category/second-subcategory"
    -
        class: Everlution\Navigation\Item\Url
        label: "Blog"
        url: "/blog"
        children:
            -
                class: Everlution\Navigation\Item\Url
                label: "ID with slug"
                url: "/blog/xxx"
                matches: # regex based match
                    -
                        class: Everlution\Navigation\Voter\Regex\RegexMatch
                        pattern: ".*/[0-9]+-[a-z]+"
                        modifiers: "xi"
            -
                class: Everlution\Navigation\Item\Url
                label: "Second"
                url: "/blog/second"
                matches: # multiple matches
                    -
                        class: Everlution\Navigation\Voter\Prefix\PrefixMatch
                        prefix: "/blog/second"
                    -
                        class: Everlution\Navigation\Voter\Prefix\PrefixMatch
                        prefix: "/blog/2nd"
    -
        class: Everlution\Navigation\Item\Url
        label: "Contact"
        url: "/contact"
        matches:
            -
                class: Everlution\Navigation\Voter\Exact\ExactMatch
                prefix: "/contact-us"
            -
                class: Everlution\Navigation\Voter\Regex\RegexMatch
                pattern: "^.*ont.*$"
                modifiers: "i"
```

After creating the provider you can access the Navigation via NavigationRegister which is defined
as service `everlution.navigation.register`:

```php
// somewhere where the Container is accessible

$register = $this
    ->container
    ->get('everlution.navigation.register');

// first argument is either filename of YAML definition
// or name of custom Provider::getName(); second argument is just label
$navigation = $register->getNavigation('frontend', 'Frontend navigation');
```

## Rendering

The bundle provides basic Twig extension and YAML data provider so you can define
your navigation within YAML file and start to use it right away with registered extension:

```twig
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- ... -->
    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- render navigation which is defined by frontend.yml -->
{{ render_navigation('frontend') }}
<!-- render breadcrumbs for navigation defined by frontend.yml -->
{{ render_breadcrumbs('frontend') }}
<!-- render navigation configured by top_nav.yml using template defined in Resources\Navigation\tab_nav.html.twig -->
{{ render_navigation('tab_nav', "AppBundle::Navigation/top_nav.html.twig") }}

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

```

There are default templates which can render navigation and breadcrumbs provided by this bundle
and they are using Bootstrap so in order to use them properly you need to include bootstrap within
your template as shown above.

If you want to use custom template you can specify it as second optional parameter in both `render_navigation()`
and `render_breadcrumb()` functions. You can use any number of navigations you like. If you decide to create your own 
custom template the following twig variables are available:

```twig
{# variables #}
{{ items }} {# array which holds NavigationItems defined in frontend.yml #}

{# functions #}
{{ extension.getUrl(item) }} {# returns URL for NavigationItem #}
{{ extension.isCurrent(item, identifier) }} {# checks wether the item is currently matched #}
{{ extension.isAncestor(item, identifier) }} {# checks wether the item is ancestor of currently matched item #}
{{ item.attributes.<attribute> }} {# use item.attributes to pass any attributes you need from configuration to template #}
```   


## TODO

- implement DoctrineDataProvider
- implement navigation structure persistence (not just read the structure but also persist it back to YAML/database etc)
- implement AuthenticationVoter eg. if the item should be rendered based on user role or current authentication context
- implement simple Navigation builder
