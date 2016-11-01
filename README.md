# Image placeholder

Provides URLs for generating generic placeholder images. You can find a live version [here](https://danbower.io/placeholder/).

## Examples

[![alt text](https://danbower.io/placeholder/100)](https://danbower.io/placeholder/100)
[![alt text](https://danbower.io/placeholder/75/100?text=foo+bar)](https://danbower.io/placeholder/75/100?text=foo+bar)
[![alt text](https://danbower.io/placeholder/175/100?text=foo+bar)](https://danbower.io/placeholder/175/100?text=foo+bar)
[![alt text](https://danbower.io/placeholder/75/100?bg=808080&fg=000)](https://danbower.io/placeholder/75/100?bg=808080&fg=000)

## Installation

```
git clone git@github.com:danbower/placeholder.git .
composer install --no-dev
```

## Routes

`/{length}` - {length}x{length} image

`/{width}/{height}` - {width}x{height} image

`/random` - Randomised dimensions and colours

## Customisation

##### File Format

`/200.gif`

Defaults to PNG. Supports PNG and GIF.

##### Text

`/200?text=foo+bar`

Defaults to dimensions of the image (e.g. "200x200").

##### Background Colour

`/200?bg=a55`

Defaults to black. Supports hex triplet (e.g. ffffff) and hex shorthand (e.g. fff) formats.

##### Foreground Colour

`/200?fg=a55`

Defaults to white. Supports hex triplet (e.g. ffffff) and hex shorthand (e.g. fff) formats.

##### Width constraints

`/random?min-width=100&max-width=200`

`min-width` defaults to 1 and `max-width` defaults to 1920.

##### Height constraints

`/random?min-height=100&max-height=200`

`min-height` defaults to 1 and `max-height` defaults to 1920.

## Drivers

It uses the GD image library out of the box but the dependency injection configuration within `./config/container.php` can be modified to use `App\Image\Driver\ImagickDriver` instead.

## Missing

- JPEG output
- Multi-line text
- Image driver support detection
- Make it easier to configure which image driver is used
