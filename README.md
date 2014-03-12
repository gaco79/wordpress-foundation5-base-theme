# Wordpress Foundation 5 Base Theme

This is a base theme to start your own Wordpress theme utilising the marvellousness of Zurb's Foundation 5.
I've tried to keep the file structure as simple as possible, so as not to over-complicate things.

The project makes use of Bower, Grunt and libsass. It should compile very quickly and be easy to maintain with
upgrades in future.

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

## Upgrades

`bower update`: Should pull future Foundation 5 upgrades

`npm update`: Will keep your grunt tasks up to date. Especially important for libsass / node-sass which is in early
 days and still has some bugs.

## Directory Structure

 * TEMPLATE PARTS
   * Template parts should be placed in the `/template-parts/` directory. Who'd have guessed?
   * See here for more information: http://codex.wordpress.org/Function_Reference/get_template_part
 * SCSS
   * `src/scss/_settings.scss`: Foundation configuration settings go in here
   * `src/scss/style.scss`: Your theme styles go here
 * JAVASCRIPT
   * `src/javascript/`: Is the place to drop your Javascripts. They'll be 'uglified' and the minimised versions dropped
         into the /js/ directory for you to reference in your theme.

## Theme Styling

You must style Wordpress sticky posts using the .wordpress-sticky CSS class. This is to avoid conflict between 
the .sticky class which by default Wordpress uses to mark sticky posts, and Foundation 5 also uses but to make things 
stick to the top of the page instead of scrolling off.

To avoid conflicts between Wordpress' admin bar and Foundation's tooltips, the Wordpress admin bar has
been disabled in this theme. It's easy enough to shift the Foundation Top Bar down 32px when the Wordpress admin bar is
showing, but then all tooltips appear 32px below where they should do too... If anyone has thoughts on fixing this, I'd
be happy to hear!

## Distributing your theme

I've tried to keep as many files as possible away from the main directory. For distribution, once you've built your
 theme using grunt, the whole of the `/src/`, `/bower_components/` and `/node_modules/` directories can be deleted,
 along with `Gruntfile.js`, `bower.json`, `config.rb` and `package.json`.

## What's New

 * v0.2
   * Responsive images - Uses [Foundation Interchange](http://foundation.zurb.com/docs/components/interchange.html)
   * Support for standard Wordpress alignment and caption classes
 * v0.1
   * First working theme

## More Information

There's a full write-up of the theme at [my website](http://garethcooper.com/?p=1679).