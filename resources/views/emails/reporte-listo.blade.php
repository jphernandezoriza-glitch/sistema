<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Inventario</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>¡Hola!</h2>
    <p>El reporte de productos que solicitaste ya ha sido generado con éxito.</p>
    <p>Puedes descargarlo haciendo clic en el siguiente enlace:</p>
    
    <a href="{{ $url }}" style="background: #1a8344; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Descargar Reporte CSV
    </a>

    <p style="margin-top: 20px; font-size: 12px; color: #666;">
        Este es un mensaje automático del Sistema de Inventario.
    </p>
</body>
</html>