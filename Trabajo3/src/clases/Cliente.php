<?php
    enum MetodoDePago: string {
        case TARJETA = 'tarjeta';
        case PAYPAL = 'paypal';
        case CHEQUE = 'cheque';
    }
    
    class Cliente {
        private $compras;
        private $carrito;
        private MetodoDePago $metodoPago;

        public function _construct(MetodoDePago $metodoDePago) {
            $this->compras = [];
            $this->carrito = [];
            $this->metodoPago = $metodoDePago;
        }

        public function getCompras() {
            return $this->compras;
        }

        public function getCarrito() {
            return $this->carrito;
        }

        public function getMetodoPago() {
            return $this->metodoPago;
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