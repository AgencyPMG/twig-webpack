# Twig + Webpack

This is a small set of libraries and a Symfony bundle for easily integrating the
webpack dev server into your Twig templates.

## Usage in Twig

```twig
{% webpack %}
<script src="{{ asset('assets/js/bundled.js') }}"></script>
{% endwebpack %}
```

If webpack is in dev mode (see below), the `asset(...)` call is overridden to
point to the webpack dev server. Additionally the webpack
[dev server JS](https://webpack.github.io/docs/webpack-dev-server.html#inline-mode-in-html)
is added above your scripts to provide auto/hot reloading.
