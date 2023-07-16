# Image Tools

#### Video Demo: <https://>

#### Description:

## What is it?

A web application for removing the background from simple images. If provided with a logo type image with 1 solid background colour, the site can process the image upload, replacing the background with transparent pixels, and then make the new file available for download.

## How it works

The project is written in php, and uses a php extension called ImageMagick to process the images.

### Files

#### login.php

This is the page that users will land on when first visiting the application if not logged in. It renders a login form which allows the user to authenticate themselves.

#### register.php

Similar to the login page, register.php allows new users to create an account, using an email address an password combination.

#### index.php

This file is the homepage for logged in users. It renders a form allowing the user to select an image to be processed from their filesystem, and an action to perform on the image (the default is remove background, but a meme generator is also available).

#### image.php

Is responsible for uploading the chosen file, calling "proceess" on the image, and then outputting the result on screen to the user along with a download link.

#### helpers/process.php

This file does the processing of the image. It uses the Imagick class from the ImageMagick php extension to detect the color of the first pixel in the top left corner of the image (it assumes this is the background colour). It then iterates through all the pixels of the image, comparing each one to the background colour, replacing that pixel with a transparent pixel if it is similar in colour to the background.

#### helpers/session.php

A helper file used to create sessions for users and store the user id's of logged in users in their session.

#### helpers/redirect.php

A helper file used for any files that require authentication. Will redirect the user back to the login page if they are not currently authenticated.
