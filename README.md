<h1 align="center">Alfred KAT</h1>

<p align="center">
    <a href="https://github.com/godbout/alfred-kat/releases/tag/2.0.0"><img src="https://img.shields.io/github/release/godbout/alfred-kat.svg" alt="GitHub Release"></a>
    <a href="https://travis-ci.com/godbout/alfred-kat"><img src="https://img.shields.io/travis/com/godbout/alfred-kat/master.svg" alt="Build Status"></a>
    <a href="https://scrutinizer-ci.com/g/godbout/alfred-kat"><img src="https://img.shields.io/scrutinizer/g/godbout/alfred-kat.svg" alt="Quality Score"></a>
    <a href="https://scrutinizer-ci.com/g/godbout/alfred-kat"><img src="https://scrutinizer-ci.com/g/godbout/alfred-kat/badges/coverage.png?b=master" alt="Code Coverage"></a>
    <a href="https://github.com/godbout/alfred-kat/releases"><img src="https://img.shields.io/github/downloads/godbout/alfred-kat/total.svg" alt="GitHub Downloads"></a>
</p>

___

# WHAT IS THAT

Get your KAT torrents without all the advertising crap. Type "kat" followed by what you're looking for, wait a bit (it's quick), choose your torrent and make some space on your HD.

# MANDATORY SCREENSHOT

![Beautiful Screenshot](https://github.com/godbout/alfred-kat/blob/master/resources/screenshots/usage.gif "Beautiful Screenshot")

# WHY IS THAT

There's a [KAT workflow](http://www.packal.org/workflow/kat-search) already on [packal.org](http://www.packal.org), but it doesn't work for me (SSL error). I contacted the author but got no answer, so I built this one. If the other one on Packal works it might be better to use it, it might have more options, or maybe not, I don't know, la la la la la.

# SETUP

NO SETUP! But the KAT URL is an Alfred workflow variable so you can replace it with a mirror in case the main site is down.

# PRO USERS

The workflow opens the magnet with the magnet default application of your Mac. If you prefer using a command-line client, you can add a `cli` variable in the [Workflow Environment Variables](https://www.alfredapp.com/help/workflows/advanced/variables/#environment). The value should be the full path to your torrent client with a `{magnet}` variable that will be replaced by the selected magnet (e.g. `/usr/local/bin/transmission-remote -a {magnet}`).

You can also copy the magnet to the clipboard rather than opening it (and starting the download) by using the ⌘ modifier.

# DOWNLOAD

[Release page](https://github.com/godbout/alfred-kat/releases/latest)
