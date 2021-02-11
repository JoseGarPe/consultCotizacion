<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
</head>
<body>
                <div class="table-responsive">
					<table id="informacionCotizacion" class="display table" style="width:100%">
				        <thead>
				            <tr>
				                <th>Fecha</th>
								<th>Informacion</th>
								<th>fecha</th>
								<th>Usuario</th>
								<th>Contacto</th>
								<th>Estado</th>
				            </tr>
				        </thead>
				        <tbody id="datosMovimientos">
				        	
				        </tbody>
				        <tfoot>
				            <tr>
				                <th>Fecha</th>
								<th>Informacion</th>
								<th>Solicito desde</th>
								<th>Usuario</th>
								<th>Contacto</th>
								<th>Contactado</th>
				            </tr>
				        </tfoot>
				    </table>
				</div>

 
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.jss"></script>
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
							imprimir +=`
								<tr>
									<td><label>${valor.created_at}</label></td>
									<td>${valor.carrito}</td>
									<td class="text-success">+<span>$</span> ${valor.bandera}</td>
									<td>${valor.nombre}</td>
									<td>${valor.telefono} / ${valor.correo}</td>
									<td>${valor.contactado}</td>
								</tr> `;
					
					}
			
				informacion.innerHTML=imprimir;
				$('#example22s').DataTable();
				//  informacionInversion();
		
	    }
	});
}
</script>
</body>
</html>