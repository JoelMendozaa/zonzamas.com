<?php



    class Libro extends Tabla
    {
        const TABLA = 'usuarios';

        function __construct()
        {
            parent::__construct(self::TABLA);

        }



        function existeLibro($nombre,$email, $edad,$id='')
        {
            $opt = [];
            
            $opt['select']['nombre']     = '';
            $opt['where']['nombre']      = $nombre;
            $opt['where']['email']       = $email;
            $opt['where']['edad']       = $edad;

            if(!empty($id))
                $opt['notwhere']['id'] = $id;
      
        
        
            $resultado = $this->seleccionar($opt);

            return $resultado->num_rows;
            
        }
    }