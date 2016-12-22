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
        class: Everlution\Navigation\NavigationItem
        label: "Home"
        identifier: "/"
    -
        class: Everlution\Navigation\NavigationItem
        label: "Blog"
        identifier: "/blog"
        children:
            -
                class: Everlution\Navigation\NavigationItem
                label: "First"
                identifier: "/blog/first"
            -
                class: Everlution\Navigation\NavigationItem
                label: "Second"
                identifier: "/blog/second"
    -
        class: Everlution\Navigation\NavigationItem
        label: "Contact"
        identifier: "/contact"
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

## TODO

- implement renderer(s)
- implement TWIG extension for rendering navigation
- implement NavigationItem which will use Symfony router for generating URIs
