## Sources of [Big Pile of Vim-like][pile] ##

The site is a list of Vim-like applications and Vim-emulation plugins.
And this repository contains a bit of PHP code and a dumb database in JSON
format behind the site.

### Contributing ###

If you wish to add a new item, edit `data.json` file.  Prefer placing new items
next to other items from the same category.  Also please provide justification
for something being Vim-like (e.g., with a link to documentation), so it's
easier to check.

#### Format ####

Each item is described by a dictionary like this:

```json
{
    "name": "<< human-readable name >>",
    "id": "<< unique id for URL >>",
    "descr": "<< description >>",
    "url": "<< home page >>",
    "license": "<< license >>",
    "languages": [ "<< main language >>", "<< secondary language >>" ],
    "category": "<< e.g., 'Text Browsers' >>",
    "type": "<< apps / plugs / confs >>",
    "comments": [ "<< things like URL to a tutorial for making Vim-like >>" ],
    "ui": "<< terminal / graphics toolkit >>",
    "added": << UNIX timestamp of addition >>,
    "updated": << UNIX timestamp of a noticeable change >>,
    "state": {
        "name": "<< inactive / discontinued >>",
        "since": << UNIX timestamp of last observed maintenance activity >>,
        "comment": "<< things like reason for discontinuing the project >>"
    }
}
```

Avoid use of emojis in all fields, they don't add anything useful but can often
appear as a confusing blank square.

Markdown is expanded in the values of `descr`, `comments` and `state.comment`.
Mention `id` of another item in brackets to link to it.

"GPL" license means GPL of any version and "BSD-like" means any kind of
BSD/MIT/X Consortium license.  Might be worth fixing in the future.

### Configuration ###

Can create `config.php` in the root with something like:

```php
<?php
$webRoot = '/vim';
?>
```

### License ###

On code: [Apache 2.0][apache]

On data: [CC BY-SA 4.0][cc-by-sa]


[pile]: https://vim.reversed.top/
[apache]: https://www.apache.org/licenses/LICENSE-2.0
[cc-by-sa]: https://creativecommons.org/licenses/by-sa/4.0/
