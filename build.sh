#!/bin/bash
PRODUCT_DIR="Tofu"

SRC_DIR="src"
NONE_USE="$OUTPUT_DIR  build.sh"
OUTPUT_FILE="$PRODUCT_DIR.tar.gz"
OUTPUT_DIR="output"
mkdir -p $OUTPUT_DIR
rm -rf $OUTPUT_DIR/*
mkdir -p $OUTPUT_DIR/$PRODUCT_DIR
cp -r $SRC_DIR/* $OUTPUT_DIR/$PRODUCT_DIR
cd $OUTPUT_DIR
find ./ -name .svn -exec rm -rf {} \;
find ./ -name .git -exec rm -rf {} \;
tar zcvf $OUTPUT_FILE $PRODUCT_DIR/*
rm -rf $PRODUCT_DIR
