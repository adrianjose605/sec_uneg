angular.module('grupo_usuario').
controller('pais', ['$scope','$http','$mdToast', function($scope,$http,$mdToast){
	$scope.pais={};
	$scope.pais2={};
	$scope.busqueda={estatus:true,query:''};
	$scope.paginador={valor:true};
	
	$scope.contador=0;
	$scope.submitted = false;


	$scope.resetForm = function(){
		$scope.pais=angular.copy({});
		$scope.pais2=angular.copy({});
		$scope.submitted=false;
	}


	$scope.getPais= function(id){
		console.log('/Admin/pais/ver/'+id);
		$http.get('Admin/pais/ver/'+id).
			success(function(data, status, headers, config) {				
					data.estatus=data.estatus=='1';
					console.log(data);
					$scope.pais2=data;					
					console.log($scope.pais2);
					var $j = jQuery.noConflict();
	                $j("#modificar_pais").modal("show");				
			}).
			error(function(data, status, headers, config) {
				console.log(status);
				hacerToast('error','Error '+status,$mdToast);
			});
	}
		$scope.recargar=function(){
			$scope.paginador.valor=!$scope.paginador.valor;
		}


	$scope.getResource = function (params, paramsObj) {	
		if(!paramsObj){
			console.log('Cambio  de Asignacion');
			paramsObj=$scope.paginador;
			console.log(paramsObj);
		}

	
		$scope.paginador=paramsObj;
		console.log('Antes de la Carga Inicial');
		console.log($scope.paginador);

		var urlApi = 'Admin/pais/tabla_principal_paises/'+paramsObj.count+'/'+paramsObj.page+'/';
		if(paramsObj.sortBy){
			urlApi+=paramsObj.sortBy+'/'+paramsObj.sortOrder;    
		}

		return $http.post(urlApi,$scope.busqueda).then(function (response) {
			console.log(response);
			$scope.contador=response.data.pagination.size;
			return {
				'rows': response.data.rows,
				'header': response.data.header,
				'pagination': response.data.pagination,
				'sortBy': response.data['sort-by'],
				'sortOrder': response.data['sort-order']
			}
		});
	};



	$scope.registrar_pais=function(tipo){	
		var url='',obj={};

		if(tipo){
			url='Admin/pais/nuevo_pais';
			obj=$scope.pais;
		}else{
			url='Admin/pais/modificar_pais';
			obj=$scope.pais2;
			console.log($scope.pais2);

		}
		$scope.submitted = true;
		if ((tipo&&$scope.formPais.$valid)||(!tipo&&$scope.formPaisM.$valid)) {
			$http.post(url, obj).
			success(function(data, status, headers, config) {
				if(data.status){
					hacerToast('success',data.mensaje,$mdToast);
					$scope.recargar();
				}
				else
					hacerToast('error',data.mensaje,$mdToast);   
			}).
			error(function(data, status, headers, config) {
				console.log(status);
				hacerToast('error','Error '+status,$mdToast);
			});
		}else{

		}

	};

}]);
