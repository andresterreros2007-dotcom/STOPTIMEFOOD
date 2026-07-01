<?php

$Laconexion = mysqli_connect("localhost", "root", "", "proyecto");

if (!$Laconexion) {
    die("La conexión ha fallado: " . mysqli_connect_error());
}

// ===================== INSERTAR =====================
if (isset($_POST['insertar'])) {

    $cat      = $_POST["categoria"]   ?? "";
    $prod     = $_POST["producto"]    ?? "";

    // Armar fechas en formato YYYY-MM-DD para MySQL
    $fechaIng  = ($_POST["anioingreso"] ?? "") . "-" . str_pad($_POST["mesingreso"]  ?? "", 2, "0", STR_PAD_LEFT) . "-" . str_pad($_POST["diaingreso"]  ?? "", 2, "0", STR_PAD_LEFT);
    $fechaElab = ($_POST["anioelab"]    ?? "") . "-" . str_pad($_POST["meselabo"]    ?? "", 2, "0", STR_PAD_LEFT) . "-" . str_pad($_POST["diaelab"]     ?? "", 2, "0", STR_PAD_LEFT);
    $fechaVenc = ($_POST["aniovenci"]   ?? "") . "-" . str_pad($_POST["mesvenci"]    ?? "", 2, "0", STR_PAD_LEFT) . "-" . str_pad($_POST["diavenci"]   ?? "", 2, "0", STR_PAD_LEFT);

    $stmt = mysqli_prepare($Laconexion,
        "INSERT INTO productos (categoria, producto, fecha_ing, fecha_elab, fecha_venc)
         VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param($stmt, "sssss", $cat, $prod, $fechaIng, $fechaElab, $fechaVenc);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "ok", "mensaje" => "Producto registrado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => mysqli_error($Laconexion)]);
    }

    mysqli_stmt_close($stmt);
    exit;
}

// ===================== OBTENER TODOS =====================
if (isset($_GET['obtener'])) {

    // Formatear fechas a DD/MM/YYYY al devolverlas
    $resultado = mysqli_query($Laconexion,
        "SELECT id, categoria, producto,
                DATE_FORMAT(fecha_ing,  '%d/%m/%Y') AS fecha_ing,
                DATE_FORMAT(fecha_elab, '%d/%m/%Y') AS fecha_elab,
                DATE_FORMAT(fecha_venc, '%d/%m/%Y') AS fecha_venc,
                fecha_venc AS fecha_venc_raw
         FROM productos
         ORDER BY id DESC"
    );

    $productos = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $productos[] = $fila;
    }

    echo json_encode($productos);
    exit;
}

// ===================== ELIMINAR =====================
if (isset($_POST['eliminar'])) {

    $id = $_POST["id"] ?? 0;

    $stmt = mysqli_prepare($Laconexion, "DELETE FROM productos WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "ok"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => mysqli_error($Laconexion)]);
    }

    mysqli_stmt_close($stmt);
    exit;
}

// ===================== EDITAR =====================
if (isset($_POST['editar'])) {

    $id   = $_POST["id"] ?? 0;
    $cat  = $_POST["categoria"] ?? "";
    $prod = $_POST["producto"]  ?? "";

    $fechaIng  = ($_POST["anioingreso"] ?? "") . "-" . str_pad($_POST["mesingreso"] ?? "", 2, "0", STR_PAD_LEFT) . "-" . str_pad($_POST["diaingreso"] ?? "", 2, "0", STR_PAD_LEFT);
    $fechaElab = ($_POST["anioelab"]    ?? "") . "-" . str_pad($_POST["meselabo"]   ?? "", 2, "0", STR_PAD_LEFT) . "-" . str_pad($_POST["diaelab"]   ?? "", 2, "0", STR_PAD_LEFT);
    $fechaVenc = ($_POST["aniovenci"]   ?? "") . "-" . str_pad($_POST["mesvenci"]   ?? "", 2, "0", STR_PAD_LEFT) . "-" . str_pad($_POST["diavenci"]  ?? "", 2, "0", STR_PAD_LEFT);

    $stmt = mysqli_prepare($Laconexion,
        "UPDATE productos SET categoria=?, producto=?, fecha_ing=?, fecha_elab=?, fecha_venc=?
         WHERE id=?"
    );

    mysqli_stmt_bind_param($stmt, "sssssi", $cat, $prod, $fechaIng, $fechaElab, $fechaVenc, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "ok", "mensaje" => "Producto actualizado"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => mysqli_error($Laconexion)]);
    }

    mysqli_stmt_close($stmt);
    exit;
}

// =========================================================================
// ==================== NUEVAS ACCIONES: NOTIFICACIONES ====================
// =========================================================================

// 1. CREAR NOTIFICACIÓN (Evita duplicados por producto)
if (isset($_POST['accion']) && $_POST['accion'] === 'crear_notificacion') {

    $idProducto = $_POST["id_producto"] ?? 0;
    $tipo       = $_POST["tipo"] ?? "";
    $mensaje    = $_POST["mensaje"] ?? "";

    // Buscar si ya existe una notificación para este producto y este tipo
    $consulta = mysqli_prepare(
        $Laconexion,
        "SELECT id
         FROM notificaciones
         WHERE id_producto = ?
         AND tipo = ?
         LIMIT 1"
    );

    mysqli_stmt_bind_param($consulta, "is", $idProducto, $tipo);
    mysqli_stmt_execute($consulta);
    mysqli_stmt_store_result($consulta);

    if (mysqli_stmt_num_rows($consulta) > 0) {

        mysqli_stmt_bind_result($consulta, $idExistente);
        mysqli_stmt_fetch($consulta);

        echo json_encode([
            "status" => "ok",
            "id_notificacion" => $idExistente,
            "duplicada" => true
        ]);

        mysqli_stmt_close($consulta);
        exit;
    }

    mysqli_stmt_close($consulta);

    // Crear la notificación
    $stmt = mysqli_prepare(
        $Laconexion,
        "INSERT INTO notificaciones
        (id_producto, tipo, mensaje, estado)
        VALUES (?, ?, ?, 'en espera')"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "iss",
        $idProducto,
        $tipo,
        $mensaje
    );

    if (mysqli_stmt_execute($stmt)) {

        echo json_encode([
            "status" => "ok",
            "id_notificacion" => mysqli_insert_id($Laconexion),
            "duplicada" => false
        ]);

    } else {

        echo json_encode([
            "status" => "error",
            "mensaje" => mysqli_error($Laconexion)
        ]);

    }

    mysqli_stmt_close($stmt);
    exit;
}
// 2. ACEPTAR NOTIFICACIÓN (Llamado por el Service Worker al dar clic en Windows)
if (isset($_POST['accion']) && $_POST['accion'] === 'aceptar_notificacion') {
    $id = $_POST["id"] ?? 0;

    $stmt = mysqli_prepare($Laconexion, 
        "UPDATE notificaciones SET estado = 'aceptado' WHERE id = ?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "ok", "mensaje" => "Estado actualizado a aceptado"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => mysqli_error($Laconexion)]);
    }

    mysqli_stmt_close($stmt);
    exit;
}

// 3. OBTENER NOTIFICACIONES (Para la pestaña del panel de administración)
if (isset($_GET['obtener_notificaciones'])) {
    
    $resultado = mysqli_query($Laconexion,
        "SELECT tipo, mensaje, DATE_FORMAT(fecha_hora, '%d/%m/%Y %H:%i:%s') AS fecha_hora, estado 
         FROM notificaciones 
         ORDER BY id DESC"
    );

    $notificaciones = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $notificaciones[] = $fila;
    }

    echo json_encode($notificaciones);
    exit;
}

mysqli_close($Laconexion);
?>