function _reset(){
		$('#cimg').attr('src','');
		$('[name="id"]').val('');
		$('#manage-modulo').get(0).reset();
		$('#manage-piso').get(0).reset();
		$('#manage-aula').get(0).reset();

	}
	// script para separador de mil en un num con onkeyup="formatNumber(this)" en el input
	function formatNumber(input) {
  // Eliminar cualquier caracter que no sea un número
  var value = input.value.replace(/[^0-9]/g, '');
  // Aplicar el formato de separador de miles
  value = Number(value).toLocaleString();
  // Actualizar el valor del campo
  input.value = value;
}

window._conf = function($msg='',$func='',$params = []){
     $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
     $('#confirm_modal .modal-body').html($msg)
     $('#confirm_modal').modal('show')
  }
	$('table').dataTable();

function getUpdatedModule() {
  $.ajax({
    url: 'ajax.php?action=get_updated_modulo',
    method: 'POST',
    // data: { id: id },
    success: function(response) {
      $('#table-modulo').html(response);
    }
  });
}

	$('#manage-modulo').submit(function(e){
		e.preventDefault()
		$.ajax({
			url:'ajax.php?action=save_modulo',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
			success:function(resp){
			if(resp==1){
                Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'Los datos fueron guardados exitosamente.',
                showConfirmButton: false,
                timer: 2000
            });
                    getUpdatedModule();

                }
			}
		})
	})
	$('.edit_mod').click(function(){
		var cat = $('#manage-modulo')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='modulo']").val($(this).attr('data-name'))
		cat.find("#cimg").attr("src","data:image/jpg;base64,"+$(this).attr('data-img_path'))
		$('button[id=tipo]').text("Actualizar");
	$(".card-header").css("background-color", "#274d8a");
    $(".card-header").css("color", "white" );
    $("#cabeza").text("Actualizar Modulo");	
		
	})
	$('.delete_mod').click(function(){
		_conf("¿Estás seguro de eliminar este modulo?","delete_mod",[$(this).attr('data-id')])
	})
	function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
	function delete_mod($id){
		
		$.ajax({
			url:'ajax.php?action=delete_modulo',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
                Swal.fire({
                position: 'top-center',
                icon: 'danger',
                title: 'Los datos fueron eliminados exitosamente.',
                showConfirmButton: false,
                timer: 2000
            });
                   getUpdatedModule();

                }
			}
		})
	}

	// script de manage-piso

	function getUpdatedPiso(moduloId) {
  $.ajax({
    url: 'ajax.php?action=get_updated_piso',
    method: 'POST',
    data: { moduloId: moduloId },
    success: function(response) {
      $('#table-piso-' + moduloId).html(response);
      $('#manage-piso').get(0).reset();
    }
  });
}


	$('#manage-piso').submit(function(e){
		e.preventDefault();

		 var moduloId = $('select[name="modulo"]').val();

		$.ajax({
			url:'ajax.php?action=save_piso',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
			success:function(resp){
			if(resp==1){
                Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'Los datos fueron guardados exitosamente.',
                showConfirmButton: false,
                timer: 2000
            });
                   getUpdatedPiso(moduloId);

                }
			}
		})
	})

	$('.edit_piso').click(function(){
		var cat = $('#manage-piso')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='descripcion']").val($(this).attr('data-descripcion'))
		cat.find("[name='name']").val($(this).attr('data-name'))
	
		cat.find("[name='modulo']").val($(this).attr('data-modulo'))
		
		$('button[id=btnGuarda]').text("Actualizar");
	$(".card-header").css("background-color", "#274d8a");
    $(".card-header").css("color", "white" );
    $("#piso").text("Actualizar nombre del piso");	
		
	})
	$('.delete_piso').click(function(){
		_conf("¿Estás seguro de eliminar esta Carrera?","delete_piso",[$(this).attr('data-id')])
	})

	function delete_piso($id){
		
		$.ajax({
			url:'ajax.php?action=delete_piso',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
                Swal.fire({
                position: 'top-center',
                icon: 'danger',
                title: 'Los datos fueron eliminados exitosamente.',
                showConfirmButton: false,
                timer: 2000
            });
                    setTimeout(function(){
                        location.reload()
                    },2000)

                }
			}
		})
	}

	// script de manage-aula

	function getUpdatedAula(aulaId) {
  $.ajax({
    url: 'ajax.php?action=get_updated_aula',
    method: 'POST',
    data: { aulaId: aulaId },
    success: function(response) {
      $('#table-aula-' + aulaId).html(response);
      $('#manage-aula').get(0).reset();
    }
  });
}


	$('#manage-aula').submit(function(e){
		e.preventDefault();

		 var aulaId = $('select[name="piso"]').val();

		$.ajax({
			url:'ajax.php?action=save_aula',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
			success:function(resp){
			if(resp==1){
                Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'Los datos fueron guardados exitosamente.',
                showConfirmButton: false,
                timer: 2000
            });
                   getUpdatedAula(aulaId);

                }
			}
		})
	})

	$('.edit_aula').click(function(){
		var cat = $('#manage-aula')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='tipo']").val($(this).attr('data-tipo'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='min']").val($(this).attr('data-min'))
		cat.find("[name='max']").val($(this).attr('data-max'))
		cat.find("[name='numero_piso']").val($(this).attr('data-pisos'))
		cat.find("'select[name=componentes]']").val($(this).attr('data-componente'))
		// cat.find("[name='componente']").val($(this).attr('data-componente'))
		$('button[id=btnAula]').text("Actualizar");
	$(".card-header").css("background-color", "#274d8a");
    $(".card-header").css("color", "white" );
    $("#aulas").text("Actualizar nombre de la aula");	
		
	})
	$('.delete_aula').click(function(){
		_conf("¿Estás seguro de eliminar esta aula?","delete_aula",[$(this).attr('data-id')])
	})

	function delete_aula($id){
		
		$.ajax({
			url:'ajax.php?action=delete_aula',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
                Swal.fire({
                position: 'top-center',
                icon: 'danger',
                title: 'Los datos fueron eliminados exitosamente.',
                showConfirmButton: false,
                timer: 2000
            });
                    getUpdatedAula(aulaId);

                }
			}
		})
	}
	
	// script de manage-componentes

	function getUpdatedComponente() {
  $.ajax({
    url: 'ajax.php?action=get_updated_componente',
    method: 'POST',
    // data: { moduloId: moduloId },
    success: function(response) {
      $('#table-componente').html(response);
      $('#manage-componentes').get(0).reset();
    }
  });
}


	$('#manage-componentes').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:'ajax.php?action=save_componente',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
			success:function(resp){
			if(resp==1){
                Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'Los datos fueron guardados exitosamente.',
                showConfirmButton: false,
                timer: 2000
            });
                   getUpdatedComponente();

                }
			}
		})
	})

	$('.edit_componente').click(function(){
		var cat = $('#manage-componentes')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='descripcion']").val($(this).attr('data-descripcion'))
		cat.find("[name='componente']").val($(this).attr('data-name'))
		cat.find("#cimg").attr("src","data:image/jpg;base64,"+$(this).attr('data-img_path'))

		$('button[id=btncomponent]').text("Actualizar");
	$(".card-header").css("background-color", "#274d8a");
    $(".card-header").css("color", "white" );
    $("#componente").text("Actualizar nombre del componente");	
		
	})
	$('.delete_componente').click(function(){
		_conf("¿Estás seguro de eliminar este articulo?","delete_componente",[$(this).attr('data-id')])
	})

	function delete_componente($id){
		
		$.ajax({
			url:'ajax.php?action=delete_componente',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
                Swal.fire({
                position: 'top-center',
                icon: 'danger',
                title: 'Los datos fueron eliminados exitosamente.',
                showConfirmButton: false,
                timer: 2000
            });
                    getUpdatedComponente();

                }
			}
		})
	}
	