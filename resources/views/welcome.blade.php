<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>Inventarios</title>

    <style>
        body {
            font-family: sans-serif;
        }

        .contenerdor {
            display: grid;
            grid-gap: 20px;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
        }


        .lineaCaptura {
            display: inline-flex;
        }

        .lineasCaptura {
            display: grid;
            grid-gap: 15px;
        }
        .space-arround{
            justify-content: space-evenly;
        }
        .grid_datos{
            grid-column: 1/span 2;
        }
    </style>

</head>
<body>
<div class="contenerdor">
    <div id="login" class="lineasCaptura">
        <div class="lineaCaptura">
            <div><label>Usuario: </label></div>
            <div>
                <input id="user" name="user"/>
                <input type="hidden" id="token" name="token"/>
            </div>
        </div>
        <div class="lineaCaptura">
            <div><label>Password: </label></div>
            <div><input id="password" name="password" type="password"/></div>
        </div>
        <div class="lineaCaptura space-arround">
                <button id="btnLogin">Login</button>
                <button id="btnLogout">Logout</button>
        </div>
    </div>
    <div id="nuevo" class="lineasCaptura">
        <div class="lineaCaptura">
            <div><label>Descripcion: </label></div>
            <div><input id="descripcion" name="descripcion"/></div>
        </div>
        <div class="lineaCaptura">
            <div><label>Marca: </label></div>
            <div><input id="marca" name="marca"/></div>
        </div>
        <div class="lineaCaptura">
            <div><label>Numero Llantas: </label></div>
            <div><input id="numero_llantas" name="numero_llantas" /></div>
        </div>
        <div class="lineaCaptura">
            <div><label>Potencia Motor: </label></div>
            <div><input id="potencia_motor" name="potencia_motor" /></div>
        </div>
        <div class="lineaCaptura space-arround">
                <button id="btnGuardar">Guardar</button>
        </div>
    </div>
    <div id="tablaDatos"></div>
</div>

</body>

<script>
    $(function(){
        $('#btnLogin').on('click', function_login)
        $('#btnLogout').on('click', function_logout)
        $('#btnGuardar').on('click', function_guardar)

        function function_login(){
            let data = {email:$('#user').val(), password:$('#password').val()}
            fetch('/api/auth/login',
                {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
            .then(response => response.json())
            .then(datos => {
                console.log(datos);
                if(datos.ok){
                    $('#token').val(datos.access_token)
                    function_buscar()
                    alert('Ya puede ingresar y/o consultar datos')
                }else{
                    alert(datos.message)
                }
            }).catch(function(error) {
                console.log('Error al realizar la peticion:' + error.message);
            })
        }
        function function_logout(){
            fetch('/api/auth/logout',
                {
                    method: 'GET',
                    headers:{
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + $('#token').val()
                    }
                })
                .then(response => response.json())
                .then(datos => {
                    console.log(datos);
                    if(datos.ok){
                        $('#token').val('')
                        alert('Sesion cerrada...')
                    }else{
                        alert(datos.message)
                    }
                }).catch(function(error) {
                console.log('Error al realizar la peticion:' + error.message);
            })
        }
        function function_guardar(){
            let data = {descripcion:$('#descripcion').val(), marca:$('#marca').val(), numero_llantas:$('#numero_llantas').val(), potencia_motor:$('#potencia_motor').val()}
            fetch('/api/inventarios', {
                method: 'POST',
                body: JSON.stringify(data),
                headers:{
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + $('#token').val()
                    }
                })
                .then(response => response.json())
                .then(datos => {
                    console.log(datos);
                    if(datos['ok']){
                        function_buscar()
                        alert('Registro insertado')
                    }else{
                        alert(datos['message'])
                    }
                }).catch(function(error) {
                console.log('Error al realizar la peticion:' + error.message);
            })
        }
        function function_buscar(){
            fetch('/api/inventarios',{
                method: 'GET',
                headers:{
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + $('#token').val()
                    }
                })
                .then(response => response.json())
                .then(datos => {
                    console.log(datos);
                    if(datos.status == 'ok'){
                        let cadHtml = '';
                        cadHtml += '<table>'
                        cadHtml += '<tr>' +
                            '<th>Id</th>' +
                            '<th>Descripcion</th>' +
                            '<th>Marca</th>' +
                            '<th>Numero de Llantas</th>' +
                            '<th>Potencia</th>' +
                            '<th>Volante</th>' +
                            '</tr>'
                        for(let x of datos.data.inventarios){
                            console.log(x)
                            cadHtml += `<tr>
                                <td>${x.id}</td>
                            <td>${x.descripcion}</td>
                            <td>${x.marca}</td>
                            <td>${x.numero_llantas}</td>
                            <td>${x.potencia_motor}</td>
                            <td>${x.volante}</td>
                            </tr>`
                        }
                        cadHtml += '</table>';
                        console.log(cadHtml)
                        $('#tablaDatos').html(cadHtml);

                    }else{
                        alert(datos.message)
                    }
                }).catch(function(error) {
                console.log('Error al realizar la peticion:' + error.message);
            })
        }
    });
</script>
</html>
