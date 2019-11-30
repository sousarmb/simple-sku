<?php

namespace app\view;

use framework\base\bView;

class Http500 extends bView
{
    public function render()
    {
        ?>
        <html>
        <head>
            <title>Error 500</title>
        </head>
        <body>
        <h1>Error 500</h1>
        <p>Internal Server Error, please try again later</p>
        <p>Message: <?= $this->data ?></p>
        </body>
        </html>
        <?php
    }
}