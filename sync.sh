#!/bin/sh
mv -f laravel_funzy/public/index.php.saved public_html/index.php
rm -rf public_html/*
# update laravel_funzy/ to your directory name
cp -a laravel_funzy/public/* public_html
cp laravel_funzy/public/.* public_html
rm -rf public_html/index.php
cp link.sh public_html/link.sh
./public_html/link.sh
rm public_html/link.sh