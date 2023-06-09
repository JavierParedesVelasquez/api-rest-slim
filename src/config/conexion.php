<?php
if (!class_exists('db')) {
    class db{
        private $dbHost = 'localhost'; // Host de la base de datos
        private $dbUser = 'root'; // Usuario de la base de datos
        private $dbPass = ''; // Contraseña de la base de datos
        private $dbName = 'apirest'; // Nombre de la base de datos
        
        // Función para establecer la conexión a la base de datos
        public function conectDB()
        {
            $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
            // Crea una cadena de conexión usando el host y el nombre de la base de datos
            
            $dbConexion = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
            // Crea una instancia de la clase PDO pasando la cadena de conexión, el usuario y la contraseña
            
            $dbConexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Configura el atributo de errores para lanzar excepciones cuando ocurra un error
            
            return $dbConexion; // Devuelve la conexión establecida
        }
    }
}