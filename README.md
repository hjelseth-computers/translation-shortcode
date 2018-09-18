# Translation Shortcode

This shortcode providers a way to swap texts inside a post, or widget, based on what language the page hsould be shown in.

Support for getting languages from both WPML and Polylang is included.

## Usage

The shortcode is fairly simple to use, and relies on matching countries ISO codes, or the same format as returned by WordPress' `get_locale()` function.

As an example, Norwegian may be represented as `no`, but Norwegian (Bokmål) may also be represented using `nb_NO`.

If no language is provided, the sites default language will be used.

### Example shortcode

```
[hc-shortcode-translate]This is an example of a default language[/hc-shortcode-translate]
[hc-shortcode-translate lang="no"]Dette er et eksempel.[/hc-shortcode-translate]
[hc-shortcode-translate lang="en"]This is an example.[/hc-shortcode-translate]
```


## Developing

The main code for the theme lives in `src/`, this is where all PHP source files live.

### Tools

During development, everything is created and put into a `build/` folder, this will contain un-minified files for 
ease of use during development.

It's recommended to use the `watch` process in Gulp, this looks for changes to JavaScript, SASS/CSS and PHP source 
running tasks to keep the `build/`directory up to date while you are working on it.

When you are ready to release, run the `publish` Gulp task!

#### Gulp tasks

There are many more tasks in Gulp, feel free to look them up, but they're all combined into the features mentioned 
above in one way or another, and most of them don't need ot be used manually or by them selves.