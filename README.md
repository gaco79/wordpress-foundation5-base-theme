# Wordpress Foundation 5 Base Theme

This is a base theme to start your own Wordpress theme utilising the marvellousness of Zurb's Foundation 5. The files provided are the minimum necessary for a working Wordpress theme. 

The project makes use of Bower, Grunt and libsass. It should compile very quickly and be easy to maintain with upgrades in future.

## Important Note

This project is now being coded to work with Wordpress version 4.0.

Due to major upgrades to TinyMCE between WordPress 3.8 and 3.9, the [responsiveimage] shortcode will not work correctly with versions of WordPress earlier than 3.9.

## Requirements

You'll need to have the following items installed before continuing.

  * [Node.js](http://nodejs.org): Use the installer provided on the NodeJS website.
  * [Grunt](http://gruntjs.com/): Run `[sudo] npm install -g grunt-cli`
  * [Bower](http://bower.io): Run `[sudo] npm install -g bower`

## Quickstart

```bash
git clone git@github.com:gaco79/wordpress-foundation5-base-theme.git
npm install
bower install
```

While you're working on your project, run:

`grunt`

And you're set!

If you wish to force regeneration of all files, even where no changes have occurred, use the `grunt buildall` task.

## Upgrades

`bower update`: Should pull future Foundation 5 upgrades

`npm update`: Will keep your grunt tasks up to date.

## Directory Structure

* **Template Parts**
    * Template parts should be placed in the `/template-parts/` directory. Who'd have guessed?
    * See the [Wordpress get_template_part function](http://codex.wordpress.org/Function_Reference/get_template_part) for more information.
* **SCSS**
    * `src/scss/_settings.scss`: Foundation configuration settings go in here
    * `src/scss/_foundation.scss`: Include Foundation modules here for the main theme
    * `src/scss/_foundation-editor.scss`: Include Foundation modules here for the visual editor theme
    * `src/scss/style.scss`: Your theme specific styles go here
* **Javascripts**
    * `src/javascript/`: Is the place to drop your Javascripts.
    * Javascripts are 'uglified' and the minimised versions dropped into the /js/ directory for you to reference in your theme.
* **Grunt**
    * Grunt config files are separated by task. See [load-grunt-config](https://github.com/firstandthird/load-grunt-config)
    * Config files are placed in the `src/grunt/` directory

## Theme Styling

You must style Wordpress sticky posts using the .wordpress-sticky CSS class. This is to avoid conflict between the .sticky class which by default Wordpress uses to mark sticky posts, and which Foundation 5 also uses, but to make things stick to the top of the page instead of scrolling off.

To avoid conflicts between Wordpress' admin bar and Foundation's tooltips, the Wordpress admin bar has been disabled in this theme. It's easy enough to shift the Foundation Top Bar down 32px when the Wordpress admin bar is showing, but then all tooltips appear 32px below where they should do too... If anyone has thoughts on fixing this, I'd be happy to hear!

## Distributing your theme

I've tried to keep as many files as possible away from the main directory. For distribution, once you've built your theme using grunt, the whole of the `/src/`, `/bower_components/` and `/node_modules/` directories can be deleted, along with `Gruntfile.js`, `bower.json` and `package.json`.

## What's New
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

## More Information

There's a full write-up of the theme at [my website](http://garethcooper.com/?p=1679).