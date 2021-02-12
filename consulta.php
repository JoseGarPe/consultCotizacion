<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Cotizaciones</title>
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" rel="stylesheet" />
</head>
<body>
<div class="container-fluid">
<br>
  <div class="table-responsive">
					<table id="informacionCotizacion" class="display table" style="width:100%">
				        <thead>
				            <tr>
				                <th>Fecha</th>
								<th>Informacion</th>
								<th>Comentario</th>
								<th>Solicito desde:</th>
								<th>Usuario</th>
								<th>Contacto</th>
								<th>Contactado</th>
								<th>Marcar como contactado</th>
				            </tr>
				        </thead>
				        <tbody id="datosMovimientos">
				        	
				        </tbody>
				        <tfoot>
				            <tr>
				                <th>Fecha</th>
								<th>Informacion</th>
								<th>Comentario</th>
								<th>Solicito desde</th>
								<th>Usuario</th>
								<th>Contacto</th>
								<th>Contactado</th>
								<th>Marcar como contactado</th>
				            </tr>
				        </tfoot>
				    </table>
				</div>

</div>
              
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script>
	$(document).ready(function(){
		infoMovimientos();
	});

function infoMovimientos(){
    var informacion = document.getElementById('datosMovimientos');
    var imprimir ='';
    var porcentaje=0;
	$.ajax({
        url: 'https://cvmas-budget.herokuapp.com/cotizacionesCliente',
	    type: 'get',
	    headers: {
	      'Accept':'application/json',
		  'Content-Type':'application/json'
	    },
	    contentType: "application/json",
	    dataType: "json",
	    cache: false,
	    processData: false,
	    success: function(response) {
					for(let valor of response){
						if (valor.contactado=='No') {
							imprimir +=`
								<tr>
									<td><label>${valor.created_at}</label><input type="hidden" id="id_carrito" value="${valor.id_carrito}"/></td>
									<td>${valor.carrito}</td>
									<td>${valor.comentario}</td>
									<td>${valor.bandera}</td>
									<td>${valor.nombre}</td>
									<td>${valor.telefono} / ${valor.correo}</td>
									<td>${valor.contactado}</td>`;
									imprimir+=`<td><button id="contactadoMark" class="btn btn-warning" onclick="registrarDatos()">Marcar como Contactado</button></td>`;
									imprimir +=`</tr> `;
						}else{
							imprimir +=`
								<tr class="alert-success">
									<td><label>${valor.created_at}</label><input type="hidden" id="id_carrito" value="${valor.id_carrito}"/></td>
									<td>${valor.carrito}</td>
									<td>${valor.comentario}</td>
									<td>${valor.bandera}</td>
									<td>${valor.nombre}</td>
									<td>${valor.telefono} / ${valor.correo}</td>
									<td>${valor.contactado}</td>`;
									imprimir+=`<td></td>`;
									imprimir +=`</tr> `;
									}

						   
					
					}
			
				informacion.innerHTML=imprimir;
				$('#informacionCotizacion').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'print'
                    ]
                });
				//  informacionInversion();
		
	    }
	});
}

function registrarDatos(){


var id= document.getElementById('id_carrito').value;
var contactado ='Si';

  var datosCliente = {
		id:id,
		contactado:contactado
	}
	var parametros = JSON.stringify(datosCliente);
$.ajax({
	url: 'https://cvmas-budget.herokuapp.com/RegistroContactado',
	type: 'post',
	headers: {
	  'Accept':'application/json',
	  'Content-Type':'application/json'
	},
	data : parametros,
	contentType: "application/json",
	dataType: "json",
	cache: false,
	processData: false,
	success: function(response) {
	  console.log(response);
	  if(response.success == true){
		  var texto = 'Bienvenido Inicia sesion para continuar';
		  alert("Registro actualizado");
		  location.reload();
	  }else{
		alert('Esto no debio pasar');
	  }
	}
  });

}

</script>
</body>
</html>