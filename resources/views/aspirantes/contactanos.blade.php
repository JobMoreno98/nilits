<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #0073e6;
            color: #ffffff;
            padding: 10px 0;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .content {
            margin: 20px 0;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
        }
        .footer {
            text-align: center;
            color: #777777;
            font-size: 14px;
            margin-top: 20px;
            border-top: 1px solid #dddddd;
            padding-top: 10px;
        }
        .btn {
            display: inline-block;
            background-color: #0073e6;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirmación de Registro</h1>
        </div>
        <div class="content">
            <p>Hola, {{ $alumno->Nombre }}</p>
            <p>Gracias por registrarte como aspirante en nuestra universidad. Nos complace recibir tu solicitud y estamos emocionados de que hayas considerado unirte a nuestra comunidad académica.</p>
            <p>Te invitamos a estar atento a las publicaciones en nuestras plataformas oficiales, donde encontrarás información relevante sobre el proceso de admisión y las siguientes etapas. Nos pondremos en contacto contigo próximamente con más detalles.</p>
            <a href="http://www.cucsh.udg.mx/" class="btn">Visitar Plataformas</a>
            <p>Si tienes alguna pregunta, no dudes en contactarnos. Estamos aquí para ayudarte en todo lo que necesites.</p>
        </div>
        <div class="footer">
            <p>Saludos,</p>
            <p>Equipo de Admisión CUCSH</p>
            <p><a href="mailto:admisiones@universidad.edu.mx">admisiones@universidad.edu.mx</a></p>
        </div>
    </div>
</body>
</html>
