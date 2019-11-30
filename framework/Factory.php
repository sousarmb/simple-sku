<?php

namespace framework;

use \ReflectionClass;
use \ReflectionMethod;

/**
 * Description of Factory
 *
 * Instantiate a class, configured with the request dependencies in its constructor/method(s)
 */
final class Factory
{

    /**
     * Description of getInstance()
     *
     * Get the class instance, with __constructor dependencies injected
     *
     * @param string $class_ns class name with namespace
     * @return  Object
     * @throws
     */
    public static function getInstance($class_ns)
    {
        $class = new ReflectionClass($class_ns);
        $parameters = $class->getConstructor()->getParameters();
        if (count($parameters) == 0) {
            // no parameters? return the instance now
            return $class->newInstanceArgs();
        }
        // prepare/inject dependencies
        $dependencies = self::getParameters($parameters);
        //
        // return class instance
        return $class->newInstanceArgs($dependencies);
    }

    /**
     * Description of getMethod()
     *
     * Get the class instance, with __constructor dependencies injected
     *
     * @param string $class_ns class name with namespace
     * @param string $method_name class method to be inspected/prepared
     * @return  array   [object, method, method_dependencies]
     * @throws
     */
    public static function getMethod($class_ns, $method_name)
    {
        //
        // get the class instance on which the method is declared
        $object = self::getInstance($class_ns);
        //
        // check the method for dependencies
        $method = new ReflectionMethod($object, $method_name);
        $parameters = $method->getParameters();
        if (count($parameters) == 0) {
            //
            // no parameters? return now
            // instancia e metodo pedidos
            return [$object, $method, []];
        }
        //
        // get method dependencies
        $dependencies = self::getParameters($parameters);
        //
        // return class instance, method instance and dependencies
        return [$object, $method, $dependencies];
    }

    /**
     * @param array $parameters
     * @return array
     */
    private static function getParameters(Array $parameters = [])
    {
        //
        // aqui guardamos as instancias/dependencias para injectar no metodo
        // a executar
        $dependencies = [];
        //
        // sem parametros?
        if (!$parameters) {
            //
            // sim
            return $dependencies;
        }
        //
        // instanciar as dependencias
        foreach ($parameters as $parameter) {
            //
            // instanciar a classe/parametro
            $parameter_class = $parameter->getClass();
            //
            // o fqdn da classe/instancia
            $ns_name = $parameter_class->getName();
            //
            // o nome da classe /instancia
            $name = $parameter_class->getShortName();
            //
            // (libertar recursos)
            unset($parameter_class);
            //
            // recursivamente instanciar o servico/classes que depois vao
            // compor o constructor da classe pedida inicialmente
            $dependencies[] = self::getInstance($ns_name);
        }
        return $dependencies;
    }

}
