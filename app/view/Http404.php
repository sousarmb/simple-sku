<?php

namespace app\view;

use framework\base\bView;

class Http404 extends bView
{
    public function render()
    {
        ?>
        <html>
        <head>
            <title>Error 404</title>
        </head>
        <body>
        <h1>Error 404</h1>
        <p>Route not found, the resource you are looking for does not exist here</p>
        </body>
        </html>
        <?php
    }
}