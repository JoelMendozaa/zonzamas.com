<?php

    class Literal
    {
        //instancia única
        private static $instance;


        public function __construct($idioma='ES')
        {

            switch($idioma)
            {
                case 'ES':
                    $this->lit = [
                        'nombre'        => 'Nombre'
                       ,'email'         => 'Email'
                       ,'edad'          => 'Edad'
                       ,'enviar'        => 'Enviar'
                       ,'error_gen'     => 'El campo es inválido'

                    ];

                break;
            }

        }


        static public function getInstance()
        {

            if (empty(self::$instance))
            {
                self::$instance = new self();
            }

            return self::$instance;
        }
    }