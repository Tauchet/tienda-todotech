<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Ciudades</h1>
    <#list clientes as cliente>
        <tr>
            <td>${cliente.cedula}</td>
            <td>${cliente.nombreCompleto}</td>
        </tr>
    </#list>
</body>
</html>