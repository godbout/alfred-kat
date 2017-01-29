# The workflow

Currently very basic. Type "kat" followed by what you're looking for. Not filter available yet.
The KAT URL is an Alfred workflow variable, so you can replace it with a mirror in case the main site is down.

# Why

There's a [KAT workflow](http://www.packal.org/workflow/kat-search) already on [packal.org](http://www.packal.org), but it doesn't work for me (SSL error). I contacted the author but got no answer, so I built this one.
If the other one on packal works it might be better to use it, it might have more options.

# Issues

The workflow is currently slow as it's using preg functions heavily. I can't get a html parser to handle the KAT html. Planning to investigate more later.

# Todo

* Faster parsing of results
* Filter (types, etc...)