#!/bin/sh
mv -f laravel_funzy/index.php.saved public_html/index.php
rm -rf public_html/*
# update project/ to your directory name
cp -a project/public/* public_html
cp project/public/.* public_html
rm -rf public_html/index.php
cp link.sh public_html/link.sh
./public_html/link.sh
rm public_html/link.sh