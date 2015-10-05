[![devDependency Status](https://david-dm.org/gaco79/wordpress-foundation5-base-theme/master/dev-status.svg)](https://david-dm.org/gaco79/wordpress-foundation5-base-theme#info=devDependencies)

# Wordpress Foundation 5 Base Theme

This is a base theme to start your own [Wordpress](http://wordpress.org) theme utilising the marvellousness of [Zurb's Foundation 5](http://foundation.zurb.com/). The files provided are the minimum necessary for a working Wordpress theme.

The project makes use of Bower and Gulp. It should compile very quickly, using libsass for SCSS, and be easy to maintain with upgrades in future.

## Important Notes

As of v0.4.0 project now is being developed to use Gulp instead of Grunt as the build system. This breaks compatibility with older versions of this project.

Due to major upgrades to TinyMCE between WordPress 3.8 and 3.9, the [responsiveimage] shortcode will not work correctly with versions of WordPress earlier than 3.9.

## Requirements

You'll need to have the following items installed before continuing.

  * [Node.js](http://nodejs.org): Use the installer provided on the NodeJS website.
  * [Gulp](http://http://gulpjs.com/): Run `[sudo] npm install -g gulp`
  * [Bower](http://bower.io): Run `[sudo] npm install -g bower`

## Quickstart

```bash
git clone git@github.com:gaco79/wordpress-foundation5-base-theme.git
npm install
bower install
```
You need to configure the build directory for your theme. It's set by default to
`./build`, so your theme will build within the project directory. It's probably better
if you change this to build to your Wordpress theme directory so that you can preview
your changes live. Copy `package.local.dist.json` to `package.local.json` and modify the `buildDir` value there to a valid location in your filesystem. The directory will be regularly deleted and re-created, so make sure you have read-write permissions to the parent directory.

While you're working on your project, run:

```bash
gulp
```

And you're set!

## Upgrades

`bower update`: Should pull future Foundation 5 upgrades

`npm update`: Will keep your gulp tasks up to date.

## Directory Structure

All of the following directories are found within the `src/` directory of the project.

* **Template Parts**
    * Template parts should be placed in the `/template-parts/` directory. Who'd have guessed?
    * See the [Wordpress get_template_part function](http://codex.wordpress.org/Function_Reference/get_template_part) for more information.
* **SCSS**
    * `scss/_settings.scss`: Foundation configuration settings go in here
    * `scss/_foundation.scss`: Include Foundation modules here for the main theme
    * `scss/_foundation-editor.scss`: Include Foundation modules here for the visual editor theme
    * `scss/style.scss`: Your theme specific styles go here
* **Javascripts**
    * `javascripts/`: Is the place to drop Javascripts that should be available on every page of your theme.
     * These will be uglified and output to the js/app.js file which is already loaded for you to use.
     * Scripts that are useful on a large number of your pages should be placed here.
     * This script is loaded just before the &lt;/body&gt; tag of your HTML.
     * With browser caching enabled (beyond the scope of this readme) this script shouldn't affect the load-times of your pages too much, but a large app.js file will have an impact on the initial page load time.
    * Javascripts places in the javascripts/plugins/ directory will be kept as individual files for you to load as and when your theme requires.
     * These are scripts that are only required on a small subset of your theme pages, e.g. tinyMCE plugins that are only necessary in the new post admin panel.

## Theme Styling

You must style Wordpress sticky posts using the `.wordpress-sticky` CSS class. This is to avoid conflict between the `.sticky` class which by default Wordpress uses to mark sticky posts, and which Foundation 5 also uses, but to make things stick to the top of the page instead of scrolling off.

### Live Reload Support

Live reload is supported. Please [read this](http://feedback.livereload.com/knowledgebase/articles/86242-how-do-i-install-and-use-the-browser-extensions-) for details of installing the appropriate browser extension.

## Wordpress Admin Bar

To avoid conflicts between Wordpress' admin bar and Foundation's tooltips, the Wordpress admin bar has been disabled in this theme. It's easy enough to shift the Foundation Top Bar down 32px when the Wordpress admin bar is showing, but then all tooltips appear 32px below where they should do too... If anyone has thoughts on fixing this, I'd be happy to hear!

## Distributing your theme

~~As of v0.3.5, the grunt-contrib-compress task will generate a zip file of your theme and place it in the dist/ directory. This can be used to distribute your theme.~~

## What's New
* v0.4.0
 * Use Gulp instead of Grunt to build the theme.
* v0.3.5
    * Auto generate zip file for theme distribution
* v0.3.4
    * Implements javascript validation using grunt-contrib-jshint
* v0.3.3
    * fixes for new libsass compiler and foundation imports.
* v0.3.2
    * grunt-notify for system notifications when builds are complete
    * style.css version number auto-generated from package.json info
* v0.3.1
    * Updated and rebuilt with newer versions of Foundation.
    * Added support for load-grunt-config to keep grunt config files readable.
* v0.3.0
    * Changes due to WordPress 3.9 upgrade of TinyMCE editor.
* v0.2
    * Responsive images - Uses [Foundation Interchange](http://foundation.zurb.com/docs/components/interchange.html)
    * Support for standard Wordpress alignment and caption classes
* v0.1
    * First working theme
