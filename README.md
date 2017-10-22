# PHP OCR API
*API for tesseract-ocr in PHP with HTML GUI*

With this you can easily implement your OCR in any application, just send the image file and the respond will be the recognized text

## API

To perform direct API query call the script using HTTP POST with this parameters:

- `image` - the uploaded image file, source for the OCR
- `lang` - optional, defaults to `eng`. This value is passed directly to the `tesseract-ocr` command as `-l` argument

## GUI

this script returns very basic HTML/JS GUI if called with HTTP GET

![Screenshot](https://user-images.githubusercontent.com/15877754/31862482-c896cbbe-b73e-11e7-8db5-a2cba7927e46.png)