#!/bin/bash
set -e

yarn

#npm rebuild node-sass

yarn encore dev-server --host 0.0.0.0 --disable-host-check
