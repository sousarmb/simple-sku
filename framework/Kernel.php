<?php

namespace framework;

use framework\interfaces\iView;
use framework\interfaces\iController;

class Kernel
{
    public function __contruct()
    {
    }

    public function go($route)
    {
        // empty route data
        if (!$route) {
            $this->handleEmptyRoute();
        }

        // lets get the handler for the route
        list ($uri, $class, $method) = $route;
        if (is_null($method)) {
            // render a view
            $handler = Factory::getInstance($class);
            $instance = $handler;
        } else {
            // process a controller
            $handler = Factory::getMethod($class, $method);
            list($instance, $method, $dependencies) = $handler;
        }

        // do not show framework output
        ob_clean();

        $output = null;
        if ($instance instanceof iController) {
            $output = $method->invokeArgs($instance, $dependencies);
            try {
                $instance->post();
            } catch (\Exception $e) {
                $this->handleInternalServerError($e->getMessage());
            }

        } elseif ($instance instanceof iView) {
            echo $instance->render();
            header('Content-Type: text/html', true, 200);
            exit;
        }

        if ($output instanceof iView) {
            echo $output->render();
            $this->sendHeaders([[200, 'Content-Type: text/html']]);
        } else {
            echo json_encode($output);
            $this->sendHeaders([[200, 'Content-Type: application/json']]);
        }

        ob_end_flush();
        exit;
    }

    private function handleEmptyRoute()
    {
        $view = new \app\view\Http404;
        $this->sendHeaders([[404, 'Page not found']]);
        echo $view->render();
        ob_end_flush();
        exit;
    }

    private function handleInternalServerError($message)
    {
        $view = new \app\view\Http500;
        $view->setViewData($message);
        $this->sendHeaders([[500, 'Internal Server Error']]);
        echo $view->render();
        ob_end_flush();
        exit;
    }

    private function sendHeaders($headers = [])
    {
        foreach ($headers as $header) {
            list ($status, $message) = $header;
            header($message, true, $status);
        }
    }
}
