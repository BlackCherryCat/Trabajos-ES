<?php

require_once 'Usuarios.php';

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
    }

    
?>