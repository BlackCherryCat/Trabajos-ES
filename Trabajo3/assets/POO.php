<?php
class Empleado
{
    private string $nombre;
    private int $edad;
    private float $salario;
    public function __construct(string $nombre, int $edad, float $salario)
    {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->salario = $salario;
    }

    public function __get($prop)
    {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }
    }

    public function __set($prop, $val) {
        if (property_exists($this, $prop)) {
            $this->$prop = $val;
        }
    }
    public function mostrarDetalles(){
       echo "Su nombre: " . $this->nombre . ", ";
       echo "Su edad: " . $this->edad . ", ";
       echo "Su salario: " . $this->salario;
    }
}
$emp = new Empleado("Javier", 24, 1204.4);
echo $emp->nombre;
echo "<br/>";
echo $emp->edad;
echo "<br/>";
echo $emp->salario;
echo "<br/>";

$emp2 = new Empleado("Javier", 24, 1204.4);
$emp2->nombre="Álvaro";
$emp2->edad=22;
$emp2->salario=1300;

$emp2->mostrarDetalles();
