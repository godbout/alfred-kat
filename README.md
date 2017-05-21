# The workflow

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/067fb5df6d2046e8a751d057cd6631ec)](https://www.codacy.com/app/godbout/alfred-kat?utm_source=github.com&utm_medium=referral&utm_content=godbout/alfred-kat&utm_campaign=badger)

Currently very basic. Type "kat" followed by what you're looking for. Not filter available yet.
The KAT URL is an Alfred workflow variable, so you can replace it with a mirror in case the main site is down.

# Why

There's a [KAT workflow](http://www.packal.org/workflow/kat-search) already on [packal.org](http://www.packal.org), but it doesn't work for me (SSL error). I contacted the author but got no answer, so I built this one.
If the other one on packal works it might be better to use it, it might have more options.

# Issues

The workflow is currently slow as it's using preg functions. Using the html5 parser for deeper nodes is even slower. Investigating.

# Todo

* Faster parsing of results
* Filter (types, etc...)

# Download

[Release page](https://github.com/godbout/alfred-kat/releases/latest)