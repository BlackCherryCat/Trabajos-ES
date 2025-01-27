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
            $this->metodoDePago = $metodoDePago;
        }

        public function __get(string $name) {
            if (property_exists($this, $name)) {
                return $this->$name;
            }
            throw new Exception("Propiedad '$name' no encontrada.");
        }

        public function __set(string $name, $value) {
        if ($name === 'metodoPago' && $value instanceof MetodoDePago) {
            $this->$name = $value;
        } else {
            throw new Exception("No se puede asignar el valor a la propiedad '$name'.");
        }
    }

        public function agregarCarrito(Producto $producto) {
            $this->carrito[] = $producto;
        }

        public function cambiarMetodoDePago(MetodoDePago $nuevoMetodo) {
            $this->metodoDePago = $nuevoMetodo;
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