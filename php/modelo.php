<?php

class Bd
{
    private $link;
    public function __construct()
    {
        if (!isset($this->link)) {
            $this->link = new mysqli('localhost', 'root', '', 'virtualmarket');
            if ($this->link->connect_errno) {
                $dato = "Fallo al conectar a MySQL: " . $this->link->connect_error;
                require "vistas/mensaje.php";
            } else {
                $this->link->set_charset('utf-8');
            }
        }
    }
    public function __get($var)
    {
        return $this->$var;
    }
}

class Cliente
{
    private $dniCliente;
    private $nombre;
    private $direccion;
    private $email;
    private $pwd;
    private $administrador;

    public static function getAll($link)
    {
        $consulta = "SELECT * FROM clientes";
        return $link->query($consulta);
    }
    public function __construct($dni, $nombre, $direccion, $email, $pwd, $administrador)
    {
        $this->dniCliente = $dni;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->administrador = $administrador;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function buscar($link)
    {
        $consulta = "SELECT * FROM clientes WHERE dniCliente='$this->dniCliente'";
        $result = $link->query($consulta);
        return $result->fetch_assoc();
    }

    public function insertar($link)
    {
        if ($this->buscar($link)) {
            return false;
        } else {
            $hash = password_hash($this->pwd, PASSWORD_DEFAULT);
            $consulta = "INSERT INTO clientes VALUES ('$this->dniCliente','$this->nombre','$this->direccion','$this->email','$hash', '$this->administrador')";
            return $link->query($consulta);
        }
    }

    public function modificar($link)
    {
        $consulta = "UPDATE clientes SET nombre = '$this->nombre', direccion = '$this->direccion', email = '$this->email' WHERE dniCliente = '$this->dniCliente'";
        return $link->query($consulta);
    }

    public function eliminar($link)
    {
        $consulta = "DELETE FROM clientes WHERE dniCliente='$this->dniCliente'";
        return $link->query($consulta);
    }
}

class Carrito
{
    private $productos;

    public function __construct($productos)
    {
        $this->productos = $productos;
    }

    public function insert_product($producto)
    {
        $this->productos[] = $producto;
    }

    public static function Linea_producto_carrito($id, $nombre, $precio, $cantidad)
    {
        $_SESSION['id'][$_SESSION['total']] = $id;
        $_SESSION['nombre_producto'][$_SESSION['total']] = $nombre;
        $_SESSION['precio'][$_SESSION['total']] = $precio;
        $_SESSION['cantidad'][$_SESSION['total']] = $cantidad;
    }

    public static function actualizar_cantidades_carrito($array_cantidades)
    {
        for ($i = 0; $i < count($array_cantidades); $i++) {
            $_SESSION['cantidad'][$i] = $array_cantidades[$i];
        }
    }
}

class Producto
{
    private $idProducto;
    private $nombre;
    private $idioma;
    private $foto;
    private $autor;
    private $categoria;
    private $anyo;
    private $unidades;
    private $precio;

    public function __construct($idProducto, $nombre, $idioma, $foto, $autor, $categoria, $anyo, $unidades, $precio)
    {
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->idioma = $idioma;
        $this->foto = $foto;
        $this->autor = $autor;
        $this->categoria = $categoria;
        $this->anyo = $anyo;
        $this->unidades = $unidades;
        $this->precio = $precio;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public static function getAll($link)
    {
        $consulta = "SELECT * FROM productos";
        return $link->query($consulta);
    }

    public static function lastId($link)
    {
        $consulta = "SELECT MAX(idProducto) FROM productos";
        return $link->query($consulta)->fetch_assoc();
    }

    public function buscar($link)
    {
        $consulta = "SELECT * FROM productos WHERE idProducto='$this->idProducto'";
        $result = $link->query($consulta);
        return $result->fetch_assoc();
    }

    public function insertar($link)
    {
        $consulta = "INSERT INTO productos (nombre, idioma, foto, autor, categoria, anyo, unidades, precio) VALUES ('$this->nombre','$this->idioma','$this->foto','$this->autor', '$this->categoria', '$this->anyo', '$this->unidades', '$this->precio')";
        return $link->query($consulta);
    }

    public function modificar($link)
    {
        $consulta = "UPDATE productos SET nombre = '$this->nombre', precio = '$this->precio', foto = '$this->foto', autor= '$this->autor' WHERE idProducto = '$this->idProducto'";
        return $link->query($consulta);
    }

    public function eliminar($link)
    {
        $consulta = "DELETE FROM productos WHERE idProducto='$this->idProducto'";
        return $link->query($consulta);
    }
}

class Pedido
{
    private $idPedido;
    private $fecha;
    private $dirEntrega;
    private $nTarjeta;
    private $fechaCaducidad;
    private $matriculaRepartidor;
    private $dniCliente;
    private $lineaspedidos;


    public static function getAll($link)
    {
        $consulta = "SELECT * FROM pedidos";
        return $link->query($consulta);
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function obtener_Nid($link)
    {
        $consulta = "SELECT MAX(idPedido) FROM pedidos";
        $result = $link->query($consulta)->fetch_assoc();
        $this->idPedido = $result['MAX(idPedido)'] + 1;
    }

    public function create_session_pedido()
    {
        $linea = 1;
        $this->fecha = date("Y-m-d");
        $this->dniCliente = $_SESSION['dni'];
        for ($i = 0; $i < $_SESSION['total']; $i++) {
            if ($_SESSION['cantidad'][$i] > 0) {
                $this->lineaspedidos[] = new Linea_pedido($this->idPedido, $linea, $_SESSION['id'][$i], $_SESSION['cantidad'][$i]);
                $linea++;
            }
        }
    }

    public function insertar($link)
    {
        if (!isset($this->idPedido)) {
            $consulta = "SELECT MAX(idPedido) FROM pedidos";
            $result = $link->query($consulta)->fetch_assoc();
            $this->idPedido = $result['MAX(idPedido)'] + 1;
        }
        $consulta = "INSERT INTO pedidos (idPedido, fecha, dniCliente) VALUES ('$this->idPedido','$this->fecha','$this->dniCliente')";
        $result = $link->query($consulta);
        if (isset($this->lineaspedidos)) {
            foreach ($this->lineaspedidos as $linea => $objeto) {
                $objeto->insertar($link);
            }
        }

        return $result;
    }

    public function insertar_datosPedido($link)
    {
        if (!isset($this->idPedido)) {
            $this->obtener_Nid($link);
        }
        $consulta = "INSERT INTO pedidos (idPedido, fecha, dniCliente) VALUES ('$this->idPedido','$this->fecha','$this->dniCliente')";
        $link->query($consulta);
    }

    public function buscar($link)
    {
        $consulta = "SELECT * FROM pedidos WHERE idPedido='$this->idPedido'";
        $result = $link->query($consulta);
        return $result->fetch_assoc();
    }

    public function eliminar($link)
    {
        $consulta = "DELETE FROM pedidos WHERE idPedido='$this->idPedido'";
        if ($result = $link->query($consulta)) {
            $consulta = "DELETE lineaspedidos WHERE idPedido = '$this->idPedido'";
            $link->query($consulta);
            return $result;
        } else {
            return false;
        }
    }

    public function modificar($link)
    {
        $consulta = "UPDATE pedidos SET  fecha = '$this->fecha', dniCliente = '$this->dniCliente' WHERE idPedido = '$this->idPedido'";
        return $link->query($consulta);
    }
}

class Linea_pedido
{
    private $idPedido;
    private $nlinea;
    private $idProducto;
    private $cantidad;

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __construct($idPedido, $nlinea, $idProducto, $cantidad)
    {
        $this->idPedido = $idPedido;
        $this->nlinea = $nlinea;
        $this->idProducto = $idProducto;
        $this->cantidad = $cantidad;
    }

    public function obtener_nlinea($link)
    {
        $consulta = "SELECT MAX(nlinea) FROM lineaspedidos WHERE idPedido='$this->idPedido'";
        if ($result = $link->query($consulta)) {
            $result = $result->fetch_assoc();
            $this->nlinea = $result['MAX(nlinea)'] + 1;
        } else {
            $this->nlinea = 1;
        }
    }


    public function insertar($link)
    {
        if (!isset($this->nlinea)) {
            $this->obtener_nlinea($link);
        }

        $consulta = "INSERT INTO lineaspedidos VALUES ('$this->idPedido','$this->nlinea','$this->idProducto', '$this->cantidad')";

        return $link->query($consulta);
    }

    public function buscar($link)
    {
        $consulta = "SELECT * FROM lineaspedidos WHERE idPedido='$this->idPedido' AND nlinea='$this->nlinea'";
        $result = $link->query($consulta);
        return $result;
    }

    public function buscarPedido($link)
    {
        $consulta = "SELECT * FROM lineaspedidos WHERE idPedido='$this->idPedido'";
        $result = $link->query($consulta);
        return $result;
    }

    public function eliminar($link)
    {
        $consulta = "DELETE FROM lineaspedidos WHERE idPedido='$this->idPedido' AND nlinea='$this->nlinea'";
        return $link->query($consulta);
    }

    public function modificar($link)
    {
        $consulta = "UPDATE lineaspedidos SET idProducto = '$this->idProducto', cantidad = '$this->cantidad' WHERE idPedido='$this->idPedido' AND nlinea='$this->nlinea'";
        return $link->query($consulta);
    }
}
