<?php
session_start();
require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<script>
            alert('Token de sesión inválido, serás redirigido al inicio de sesión');
            setTimeout(function() {
                window.location.href = '../../login.html';
            }, 1500);
          </script>";
    exit();
} else {
    if ($_GET['act'] == 'insert') {
        if ($_POST) {
            $codigo = $_POST['codigo']; // cod_venta
            $codigo_deposito = $_POST['codigo_deposito'];
            $codigo_cliente = $_POST['codigo_cliente']; // id_cliente
            $fecha = $_POST['fecha'];

            $hora = $_POST['hora'];
            $estado = 'activo';
            $productos = json_decode($_POST['productos'], true); // Decodificar JSON

            if (!$productos || count($productos) === 0) {
                die('Error: No se enviaron productos para registrar.');
            }

            // **Obtener el último número de factura**
            $query_factura = mysqli_query($mysqli, "SELECT MAX(nro_factura) as ultimo FROM venta");
            if ($row_factura = mysqli_fetch_assoc($query_factura)) {
                $nro_factura = $row_factura['ultimo'] + 1; // Incrementar el último número
            } else {
                $nro_factura = 1; // Valor inicial si no hay facturas
            }

            // Insertar la cabecera de la venta
            $sql_venta = "INSERT INTO venta (cod_venta, id_cliente, fecha, total_venta, estado, hora, nro_factura)
                VALUES ($codigo, $codigo_cliente, '$fecha', 0, '$estado', '$hora', $nro_factura)";
            $query_venta = mysqli_query($mysqli, $sql_venta) or die('Error al insertar la cabecera de venta: ' . mysqli_error($mysqli));

            if ($query_venta) {
                $total_venta = 0;

                // Recorrer productos y actualizar el stock
                foreach ($productos as $producto) {
                    $codigo_producto = $producto['codigo'];
                    $cantidad = $producto['cantidad'];
                    $precio = $producto['precio'];

                    // Obtener el precio unitario del producto
                    $sql_precioUnitario = "SELECT precio FROM producto WHERE cod_producto = $codigo_producto";
                    $result_precio = mysqli_query($mysqli, $sql_precioUnitario) or die('Error al obtener precio: ' . mysqli_error($mysqli));

                    if ($row_precio = mysqli_fetch_assoc($result_precio)) {
                        $precio_unitario = $row_precio['precio']; // Precio obtenido de la base de datos
                    } else {
                        die("Error: No se encontró el precio del producto con código $codigo_producto.");
                    }

                    // Calcular el total de cada producto
                    $total_producto = $cantidad * $precio;
                    $total_venta += $total_producto;

                    // Insertar en la tabla det_venta
                    $sql_detalle = "INSERT INTO det_venta (cod_producto, cod_venta, cod_deposito, det_precio_unit, det_cantidad) 
                                    VALUES ($codigo_producto, $codigo, $codigo_deposito, $precio, $cantidad)";
                    mysqli_query($mysqli, $sql_detalle) or die('Error al insertar detalle de venta: ' . mysqli_error($mysqli));

                    // Actualizar el stock
                    $query_stock = mysqli_query($mysqli, "SELECT cantidad FROM stock WHERE cod_producto=$codigo_producto AND cod_deposito=$codigo_deposito");

                    if (mysqli_num_rows($query_stock) == 0) {
                        die('Error: No hay stock registrado para este producto en este depósito.');
                    } else {
                        $row = mysqli_fetch_assoc($query_stock);
                        $stock_disponible = $row['cantidad'];

                        // Validar si hay suficiente stock
                        if ($cantidad > $stock_disponible) {
                            die('Error: Stock insuficiente. Cantidad solicitada: ' . $cantidad . ', Stock disponible: ' . $stock_disponible);
                        }

                        // Restar la cantidad del stock
                        $sql_update_stock = "UPDATE stock SET cantidad = cantidad - $cantidad 
                                             WHERE cod_producto=$codigo_producto AND cod_deposito=$codigo_deposito";

                        if (!mysqli_query($mysqli, $sql_update_stock)) {
                            die('Error al actualizar el stock: ' . mysqli_error($mysqli));
                        }
                    }
                }

                // Actualizar el total de la venta
                $sql_update_venta = "UPDATE venta SET total_venta = $total_venta WHERE cod_venta = $codigo";
                mysqli_query($mysqli, $sql_update_venta) or die('Error al actualizar el total de la venta: ' . mysqli_error($mysqli));

                // Redireccionar si todo es exitoso
                header("Location: view.php?alert=1");
            } else {
                header("Location: ../../main.php?module=ventas&alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['cod_venta'])) {
            $codigo = $_GET['cod_venta'];

            // Verificar si la venta ya está anulada
            $sql_check_estado = "SELECT estado FROM venta WHERE cod_venta=$codigo";
            $result_check = mysqli_query($mysqli, $sql_check_estado);
            if (!$result_check) {
                die('Error al consultar el estado de la venta: ' . mysqli_error($mysqli));
            }

            $venta = mysqli_fetch_assoc($result_check);
            if ($venta['estado'] == 'anulado') {
                die('Error: Esta venta ya está anulada.');
            }

            // Anular la cabecera de venta
            $sql_anular_venta = "UPDATE venta SET estado='anulado' WHERE cod_venta=$codigo";
            $result_anular_venta = mysqli_query($mysqli, $sql_anular_venta);
            if (!$result_anular_venta) {
                die('Error al anular la venta: ' . mysqli_error($mysqli));
            }

            // Revertir el stock de los productos
            $sql_detalles = "SELECT * FROM det_venta WHERE cod_venta=$codigo";
            $result_detalles = mysqli_query($mysqli, $sql_detalles);
            if (!$result_detalles) {
                die('Error al obtener detalles de la venta: ' . mysqli_error($mysqli));
            }

            while ($detalle = mysqli_fetch_assoc($result_detalles)) {
                $codigo_producto = $detalle['cod_producto'];
                $codigo_deposito = $detalle['cod_deposito'];
                $cantidad = $detalle['det_cantidad'];

                // Revertir el stock sumando la cantidad anulada
                $sql_revertir_stock = "UPDATE stock SET cantidad = cantidad + $cantidad 
                                       WHERE cod_producto=$codigo_producto AND cod_deposito=$codigo_deposito";
                $result_revertir_stock = mysqli_query($mysqli, $sql_revertir_stock);
                if (!$result_revertir_stock) {
                    die('Error al revertir stock: ' . mysqli_error($mysqli));
                }
            }

            header("Location: view.php?alert=2");
        } else {
            die('Error: El código de venta no está definido.');
        }
    }
}
?>
