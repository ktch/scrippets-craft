Scrippets
=========

A simple [CraftCMS](http://buildwithcraft.com) plugin/Twig filter that might be useful to at least 4 other people in the world.

Based on the very neat [Scrippets Wordpress Plugin](http://fountain.io/scrippets) by the wonderful people over at [Fountain](http://fountain.io), namely [John August](http://johnaugust.com) and his merry band of nerd-screenwriters.

It uses an incomplete version of [Fountain](http://fountain.io), the plain-text screenwriting syntax. It lets you embed little bits of good-looking screenplay on your page.

There is no warranty on this. I made it for myself because I needed it.

Installation
============

Put the contents of this folder in craft/plugins, and then add the contents of the scrippets.css anywhere in your CSS. That's it.

Usage
=====
```php
{{ entry.body | scrippets | raw }}
```
