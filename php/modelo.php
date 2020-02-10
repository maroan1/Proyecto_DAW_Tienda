<?php

//Conectamos la base dedatos por PDO
class Bd
{
    private $link;
    public function __construct()
    {
        if (!isset($this->link)) {
            try {
                $this->link = new PDO("mysql:host=localhost;dbname=virtualmarket", "root", "");
                $this->link->exec("set names utf8mb4");
            } catch (PDOException $e) {
                $dato = "¡Error!" . $e->getMessage() . "</br>";
                return $dato;
                die();
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
        try {
            $consulta = "SELECT * FROM clientes";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
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
        try {
            $consulta = "SELECT * FROM clientes WHERE dniCliente='$this->dniCliente'";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "</br>";
            return $dato;
            die();
        }
    }

    // public function validar($link)
    // {
    //     $fila = $this->buscar($link);
    //     if (password_verify($this->pwd, $fila['pwd'])) {
    //         try {
    //             $consulta = "SELECT dniCliente, nombre FROM clientes WHERE dniCliente='$this->dniCliente'";
    //             $result = $link->prepare($consulta);
    //             $result->execute();
    //             return $result->fetch(PDO::FETCH_ASSOC);
    //         } catch (PDOException $e) {
    //             $dato = "¡Error!: " . $e->getMessage() . "</br>";
    //             return $dato;
    //             die();
    //         }
    //     } else {
    //         return false;
    //     }
    // }

    public function insertar($link)
    {
        try {
            $hash = password_hash($this->pwd, PASSWORD_DEFAULT);
            $consulta = "INSERT INTO clientes VALUES (:dniCliente,:nombre,:direccion,:email,:pwd,:administrador)";
            $result = $link->prepare($consulta);
            $result->bindParam(':dniCliente', $this->dniCliente);
            $result->bindParam(':nombre', $this->nombre);
            $result->bindParam(':direccion', $this->direccion);
            $result->bindParam(':email', $this->email);
            $result->bindParam(':pwd', $hash);
            $result->bindParam(':administrador', $this->administrador);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function modificar($link)
    {
        try {
            $consulta = "UPDATE clientes SET nombre='$this->nombre', direccion='$this->direccion', email='$this->email', administrador='$this->administrador' WHERE dniCliente='$this->dniCliente'";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function eliminar($link)
    {
        try {
            $consulta = "DELETE FROM clientes where dniCliente='$this->dniCliente'";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }
}

class Carrito
{
    private $dniCliente;
    private $idProducto;
    private $cantidad;
    private $precio;

    public static function getAll($link)
    {
        $this->borrarCarroVacio($link);
        try {
            $consulta = "SELECT * FROM carritos";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function borrarCarroVacio($link)
    {
        try {
            $consulta = "DELETE FROM carritos where cantidad=0";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function __construct($dniCliente, $idProducto, $cantidad, $precio)
    {
        $this->dniCliente = $dniCliente;
        $this->idProducto = $idProducto;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function cargarCarrito($link)
    {
        $this->borrarCarroVacio($link);
        try {
            $consulta = "SELECT * FROM carritos WHERE dniCliente='$this->dniCliente'";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function buscar($link)
    {
        try {
            $consulta = "SELECT * FROM carritos WHERE dniCliente='$this->dniCliente' AND idProducto='$this->idProducto'";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function contarProductos($link)
    {
        try {
            $consulta = "SELECT COUNT(*) FROM carritos WHERE dniCliente='$this->dniCliente' ";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function insertar($link)
    {
        // COMPRUEBO SI EL PRODUCTO EXISTE PARA ACTUALIZAR O CREAR LA LINEA DEL CARRITO
        if ($this->buscar($link)) {
            try {
                $consulta = "UPDATE carritos SET cantidad=cantidad+$this->cantidad, precio='$this->precio' WHERE dniCliente = '$this->dniCliente' AND idProducto='$this->idProducto'";
                $result = $link->prepare($consulta);
                return $result->execute();
            } catch (PDOException $e) {
                $dato = "¡Error!: " . $e->getMessage() . "<br/>";
                return $dato;
                die();
            }
        } else {
            try {
                $consulta = "INSERT INTO carritos VALUES (:dniCliente,:idProducto,:cantidad,:precio)";
                $result = $link->prepare($consulta);
                $result->bindParam(':dniCliente', $this->dniCliente);
                $result->bindParam(':idProducto', $this->idProducto);
                $result->bindParam(':cantidad', $this->cantidad);
                $result->bindParam(':precio', $this->precio);
                return $result->execute();
            } catch (PDOException $e) {
                $dato = "¡Error!: " . $e->getMessage() . "<br/>";
                return $dato;
                die();
            }
        }
    }

    public function modificar($link)
    {
        try {
            if ($this->cantidad == 0) {
                $consulta = "DELETE FROM carritos where dniCliente='$this->dniCliente' AND idProducto='$this->idProducto'";
                $result = $link->prepare($consulta);
                return $result->execute();
            } else {
                $consulta = "UPDATE carritos SET cantidad='$this->cantidad', precio='$this->precio' WHERE dniCliente = '$this->dniCliente' AND idProducto='$this->idProducto'";
                $result = $link->prepare($consulta);
                return $result->execute();
            }
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function eliminar($link)
    {
        try {
            $consulta = "DELETE FROM carritos where dniCliente='$this->dniCliente' AND idProducto='$this->idProducto'";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function eliminarCarrito($link)
    {
        try {
            $consulta = "DELETE FROM carritos where dniCliente='$this->dniCliente'";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }
}
// class Carrito
// {
//     private $productos;

//     public function __construct($productos)
//     {
//         $this->productos = $productos;
//     }

//     public function insert_product($producto)
//     {
//         $this->productos[] = $producto;
//     }

//     public static function Linea_producto_carrito($id, $nombre, $precio, $cantidad)
//     {
//         $_SESSION['id'][$_SESSION['total']] = $id;
//         $_SESSION['nombre_producto'][$_SESSION['total']] = $nombre;
//         $_SESSION['precio'][$_SESSION['total']] = $precio;
//         $_SESSION['cantidad'][$_SESSION['total']] = $cantidad;
//     }

//     public static function actualizar_cantidades_carrito($array_cantidades)
//     {
//         for ($i = 0; $i < count($array_cantidades); $i++) {
//             $_SESSION['cantidad'][$i] = $array_cantidades[$i];
//         }
//     }
// }

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
        try {
            $consulta = "SELECT * FROM productos";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    //? Quería esto para algo?
    // public static function lastId($link)
    // {
    //     $consulta = "SELECT MAX(idProducto) FROM productos";
    //     return $link->query($consulta)->fetch_assoc();
    // }

    public function buscar($link)
    {
        try {
            $consulta = "SELECT * FROM productos WHERE idProducto='$this->idProducto'";;
            $result = $link->prepare($consulta);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function insertar($link)
    {
        try {
            $consulta = "INSERT INTO productos (nombre, idioma, foto, autor, categoria, anyo, unidades, precio) VALUES ('$this->nombre','$this->idioma','$this->foto','$this->autor', '$this->categoria', '$this->anyo', '$this->unidades', '$this->precio')";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function modificar($link)
    {
        try {
            $consulta = "UPDATE productos SET nombre = '$this->nombre', precio = '$this->precio', foto = '$this->foto', autor= '$this->autor' WHERE idProducto = '$this->idProducto'";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function eliminar($link)
    {
        try {
            $consulta = "DELETE FROM productos WHERE idProducto='$this->idProducto'";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
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
        try {
            $consulta = "SELECT * FROM pedidos";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function __construct($dniCliente)
    {
        $this->dniCliente = $dniCliente;
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
        try {
            $consulta = "SELECT MAX(idPedido) FROM pedidos";
            $result = $link->prepare($consulta);
            $result->execute();
            $valor = $result->fetch(PDO::FETCH_ASSOC);
            $this->idPedido = $valor['MAX(idPedido)'] + 1;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }


    //TODO Pasarlo a cookies o revisar como hacerlo
    // public function create_session_pedido()
    // {
    //     $linea = 1;
    //     $this->fecha = date("Y-m-d");
    //     $this->dniCliente = $_SESSION['dni'];
    //     for ($i = 0; $i < $_SESSION['total']; $i++) {
    //         if ($_SESSION['cantidad'][$i] > 0) {
    //             $this->lineaspedidos[] = new Linea_pedido($this->idPedido, $linea, $_SESSION['id'][$i], $_SESSION['cantidad'][$i]);
    //             $linea++;
    //         }
    //     }
    // }

    public function insertar($link)
    {
        $this->fecha = date("Y-m-d");
        if (!isset($this->idPedido)) {
            // try {
            //     $consulta = "SELECT MAX(idPedido) FROM pedidos";
            //     $result = $link->prepare($consulta);
            //     $result->execute();
            //     $result->fetch(PDO::FETCH_ASSOC);
            //     $this->idPedido = $result + 1;
            // } catch (PDOException $e) {
            //     $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            //     return $dato;
            //     die();
            // }
            $this->obtener_Nid($link);
        }
        try {
            $consulta = "INSERT INTO pedidos (idPedido, fecha, dniCliente) VALUES ('$this->idPedido','$this->fecha','$this->dniCliente')";
            $result = $link->prepare($consulta);
            $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }

        $cartCon = new Carrito($this->dniCliente, '', '', '');

        $dato = $cartCon->cargarCarrito($link);
        $dato->setFetchMode(PDO::FETCH_ASSOC);
        // return $dato;
        foreach ($dato->fetchAll() as $key => $value) {
            $linea = new Linea_pedido($this->idPedido, '', $value['idProducto'], $value['cantidad'], $value['precio']);
            $linea->obtener_nlinea($link);
            $linea->insertar($link);
        }
        $cartCon->eliminarCarrito($link);
        $array = array('idPedido' => $this->idPedido, 'fecha' => $this->fecha);
        return $array;

        // if (isset($this->lineaspedidos)) {
        //     foreach ($this->lineaspedidos as $linea => $objeto) {
        //         $objeto->insertar($link);
        //     }
        // }
    }

    public function insertar_datosPedido($link)
    {
        if (!isset($this->idPedido)) {
            $this->obtener_Nid($link);
        }
        try {
            $consulta = "INSERT INTO pedidos (idPedido, fecha, dniCliente) VALUES ('$this->idPedido','$this->fecha','$this->dniCliente')";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function buscar($link)
    {
        try {
            $consulta = "SELECT * FROM pedidos WHERE idPedido='$this->idPedido'";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function eliminar($link)
    {
        try {
            $consulta = "DELETE FROM pedidos WHERE idPedido='$this->idPedido'";
            $result = $link->prepare($consulta);
            if ($result->execute()) {
                try {
                    $consulta = "DELETE lineaspedidos WHERE idPedido = '$this->idPedido'";
                    $result = $link->prepare($consulta);
                    return $result->execute();
                } catch (PDOException $e) {
                    $dato = "¡Error!: " . $e->getMessage() . "<br/>";
                    return $dato;
                    die();
                }
            }
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function modificar($link)
    {
        try {
            $consulta = "UPDATE pedidos SET  fecha = '$this->fecha', dniCliente = '$this->dniCliente' WHERE idPedido = '$this->idPedido'";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }
}

class Linea_pedido
{
    private $idPedido;
    private $nlinea;
    private $idProducto;
    private $cantidad;
    private $precio;

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __construct($idPedido, $nlinea, $idProducto, $cantidad, $precio)
    {
        $this->idPedido = $idPedido;
        $this->nlinea = $nlinea;
        $this->idProducto = $idProducto;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
    }

    public function obtener_nlinea($link)
    {
        try {
            $consulta = "SELECT MAX(nlinea) FROM lineaspedidos WHERE idPedido='$this->idPedido'";
            $result = $link->prepare($consulta);
            if ($result->execute()) {
                $result = $result->fetch(PDO::FETCH_ASSOC);
                $this->nlinea = $result['MAX(nlinea)'] + 1;
            } else {
                $this->nlinea = 1;
            }
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }


    public function insertar($link)
    {
        if (!isset($this->nlinea)) {
            $this->obtener_nlinea($link);
        }
        try {
            $consulta = "INSERT INTO lineaspedidos VALUES ($this->idPedido, $this->nlinea, $this->idProducto, $this->cantidad, $this->precio)";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function buscar($link)
    {
        try {
            $consulta = "SELECT * FROM lineaspedidos WHERE idPedido='$this->idPedido' AND nlinea='$this->nlinea'";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function buscarPedido($link)
    {
        try {
            $consulta = "SELECT * FROM lineaspedidos WHERE idPedido='$this->idPedido'";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result;
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function eliminar($link)
    {
        try {
            $consulta = "DELETE FROM lineaspedidos WHERE idPedido='$this->idPedido' AND nlinea='$this->nlinea'";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }

    public function modificar($link)
    {
        try {
            $consulta = "UPDATE lineaspedidos SET idProducto = '$this->idProducto', cantidad = '$this->cantidad' WHERE idPedido='$this->idPedido' AND nlinea='$this->nlinea'";
            $result = $link->prepare($consulta);
            return $result->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }
}
