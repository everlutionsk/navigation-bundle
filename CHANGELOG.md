CHANGELOG
=========

v2.0.0
------

This version breaks many of the interfaces, many of the interfaces were removed and many of them was added.
In this version we removed loading the navigation definitions from YAML files and instead we focus on
providing clean and extensible interface for creating navigation items and grouping them to navigation
instances. We also improved "out of box" features and the documentation.

Here is list of all features this release contains:

 * version 2.0.0 of everlutionsk/navigation library
 * registration of navigation instances, url providers and match voters by tagged services
 * ability to use custom router which implements Symfony's `RouterInterface`
 * default templates for navigation and breadcrumbs for Bootstrap 4
 * Twig extension for rendering navigation and breadcrumbs for navigation containers defined
   within registry
 * helper functions for easier rendering of custom navigation and breadcrumbs
 * bridge for everlutionsk/navigation so it can be used with Symfony's `Router`, `Translator`
   and `Request`

