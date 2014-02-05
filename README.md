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
git clone git@github.com:zurb/foundation-libsass-template.git
npm install && bower install
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
   * `src/scss/style.scss`: Application styles go here
 * JAVASCRIPT
   * `src/javascript/`: Is the place to drop your Javascripts. They'll be 'uglified' and the minimised versions dropped
         into the /js/ directory for you to reference in your theme.

## Distributing your theme

I've tried to keep as many files as possible away from the main directory. For distribution, once you've built your
 theme using grunt, the whole of the `/src/`, `/bower_components/` and `node_modules` directories can be deleted,
 along with `Gruntfile.js`, `bower.json`, `config.rb` and `package.json`.