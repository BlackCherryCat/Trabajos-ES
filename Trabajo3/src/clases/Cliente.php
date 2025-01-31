<?php

include 'Usuarios.php';

    enum MetodoDePago: string {
        case TARJETA = 'tarjeta';
        case PAYPAL = 'paypal';
        case CHEQUE = 'cheque';
    }
    
    class Cliente extends Usuario{
        private $compras;
        private $carrito;
        protected MetodoDePago $metodoPago;

        public function _construct($idUsuario, $email, $pass, $nombre, MetodoDePago $metodoDePago) {
            parent::__construct($idUsuario, $email, $pass, $nombre);
            $this->compras = [];
            $this->carrito = [];
            $this->metodoPago = $metodoDePago;
        }

        public function agregarCarrito(Producto $producto) {
            $this->carrito[] = $producto;
        }

        public function cambiarMetodoDePago(MetodoDePago $nuevoMetodo) {
            $this->metodoPago = $nuevoMetodo;
        }

        public function realizarPedido() {
            if (!empty($this->carrito)) {
                $this->compras[] = $this->carrito;
                $this->vaciarCarrito();
                echo "Pedido realizado con éxito.";
            } else {
                echo "El carrito está vacío, no se puede realizar el pedido.";
            }
        }

        public function vaciarCarrito() {
                $this->carrito = [];
        }

        //Método que registra un usuario en la base de datos
        public function registerBD(){
            $host = "localhost";
            $user = "root";
            $pass = "";
            $name_db = "Trabajo3";

            $conexion = mysqli_connect($host, $user, $pass, $name_db);

            $search = "SELECT * FROM usuario WHERE email = '$this->email'";

            $busqueda = mysqli_query($conexion, $search);

            if(mysqli_num_rows($busqueda) == 0){
                $query = "INSERT into usuario (nombre, email, pass, isAdmin) VALUES
                ('$this->nombre', '$this->email', '$this->pass', 0);";

                $resultado = mysqli_query($conexion, $query);

                if(mysqli_affected_rows($conexion) == 1){
                    echo "Usurio registrado correctamente";
                }else{
                    echo "Error al registrar usuario. Consulte su proveedor de Bases de Datos";
                }
            }else{
                echo "El email proporcionado ya está registrado en nuestra base de datos, pruebe con otro";
            }
        }
    }

    
?>
