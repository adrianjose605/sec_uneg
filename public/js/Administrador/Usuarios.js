angular.module('secuneg')

.controller('GUsuarios', ['$scope','$http','$mdToast', us])



	function us($scope,$http,$mdToast){
	$scope.user={};
	$scope.permiso={};$scope.permiso2={};
	
	$scope.busqueda={estatus:false,query:''};
	$scope.paginador={valor:true};
	
	$scope.contador=0;
	$scope.submitted = false;

	$scope.resetForm = function(){
		$scope.user=angular.copy({});
		$scope.permiso=angular.copy({});
		$scope.permiso2=angular.copy({});
		$scope.submitted=false;
	}


	$scope.getGrupos= function(id){
		console.log('/User/GUsuarios/verG/'+id);
		$http.get('User/GUsuarios/verG/'+id).
			success(function(data, status, headers, config) {				
					data.permisos=data.permisos=='1';
					data.boton_panico=data.boton_panico=='1';
					data.enviar_noticias=data.enviar_noticias=='1';
					data.estatus=data.estatus=='1';
					data.crear_usuarios=data.crear_usuarios=='1';
					data.permisos=data.permisos=='1';
					data.ver_noticias=data.ver_noticias=='1';

					//console.log(data);
					$scope.permiso=data;					
					//console.log($scope.alerta_nueva);
					var $j = jQuery.noConflict();
	                $j("#modificar_grupo").modal("show");				
			}).
			error(function(data, status, headers, config) {
				console.log(status);
				hacerToast('error','Error '+status,$mdToast);
			});
	}
		$scope.recargar=function(){
			$scope.paginador.valor=!$scope.paginador.valor;
		}


	$scope.getResourceG = function (params, paramsObj) {	
		if(!paramsObj){
			console.log('Cambio  de Asignacion');
			paramsObj=$scope.paginador;
			console.log(paramsObj);
		}

		
		$scope.paginador=paramsObj;
		console.log('Antes de la Carga Inicial');
		

		var urlApi = 'User/GUsuarios/tabla_principal_grupos/'+paramsObj.count+'/'+paramsObj.page+'/';
	
		if(paramsObj.sortBy){
			urlApi+=paramsObj.sortBy+'/'+paramsObj.sortOrder;    
		}

		return $http.post(urlApi,$scope.busqueda).then(function (response) {
			
			
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

	$scope.registrar_grupo=function(tipo){	
		var url='',obj={};
			if(tipo){
			url='User/GUsuarios/nuevo_grupo';
			obj=$scope.permiso2;
		}else{
			
			url='User/GUsuarios/modificar_grupo';
			obj=$scope.permiso;
			}
			
			
			
			console.log(obj);
			
		$scope.submitted = true;
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
		

	};


	$scope.registrar_alerta=function(){	
		var url='',obj={},obj2={};

			url='User/GUsuarios/modificar_usuarios';

			obj=$scope.alerta_nueva;
			obj2=$scope.alerta_nueva;
			if(obj2["estatus"]){
				obj2["estatus"]=1;
			}
			
			
			
		$scope.submitted = true;
		
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
		

	};

}
 