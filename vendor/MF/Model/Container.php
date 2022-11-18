<?php

    namespace MF\Model;

    use App\Connection;

    class Container {

        public static function getModel($model){
            $class = "\\App\\Models\\".ucfirst($model);
            $conn = Connection::getDb();

            //retornar o modelo solicidato já instânciado, inclusive com a conexão
            //estabelecida

            return new $class($conn);
        }

    }

?>