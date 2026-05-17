<?php
require_once '../db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['cart']) || empty($data['cart'])) {
        echo json_encode(['success' => false, 'message' => 'El carrito está vacío.']);
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Calcular total
        $total = 0;
        foreach ($data['cart'] as $item) {
            $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id_producto = ?");
            $stmt->execute([$item['id']]);
            $producto = $stmt->fetch();
            if ($producto) {
                $total += $producto['precio'] * $item['cantidad'];
            }
        }

        // Insertar Venta
        // Valores fijos para cliente, empleado y metodo_pago por simplicidad (usando los que existen en el INSERT de la BD)
        $idCliente = 1; // Adrian
        $idEmpleado = 2; // Ana
        $idMetodoPago = 1; // Efectivo

        $stmtVenta = $pdo->prepare("INSERT INTO ventas (total, id_cliente, id_empleado, id_metodo_pago) VALUES (?, ?, ?, ?)");
        $stmtVenta->execute([$total, $idCliente, $idEmpleado, $idMetodoPago]);
        $idVenta = $pdo->lastInsertId();

        // Insertar Detalle Ventas
        foreach ($data['cart'] as $item) {
            $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id_producto = ?");
            $stmt->execute([$item['id']]);
            $producto = $stmt->fetch();
            
            if ($producto) {
                $precio_unitario = $producto['precio'];
                $subtotal = $precio_unitario * $item['cantidad'];
                
                $stmtDetalle = $pdo->prepare("INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
                $stmtDetalle->execute([$idVenta, $item['id'], $item['cantidad'], $precio_unitario, $subtotal]);

                // Actualizar stock
                $stmtStock = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
                $stmtStock->execute([$item['cantidad'], $item['id']]);
            }
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Compra realizada con éxito', 'id_venta' => $idVenta]);

    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error al procesar la compra: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
