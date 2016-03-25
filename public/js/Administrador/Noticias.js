angular.module('secuneg')

.controller('noticias', ['$scope','$http','$mdToast', secu])

.controller('List', ['MyService', lis]);
 
  function lis(listener){
   // $scope.customers = MyService.getCustomers();

  };


	function secu($scope,$http,$mdToast,MyService){
	$scope.pais={};
	$scope.alerta_nueva={};
	$scope.busqueda={estatus:false,query:''};
	$scope.paginador={valor:true};
	
	$scope.contador=0;
	$scope.submitted = false;

	var ws = new WebSocket("ws://localhost:9000/sec_uneg/conexion/server.php");
    
   ws.onopen = function(){  
        // console.log("Socket has been opened!");  
    };
    
	$scope.resetForm = function(){
		$scope.pais=angular.copy({});
		$scope.alerta_nueva=angular.copy({});
		$scope.submitted=false;
	}


	$scope.getAlerta= function(id){
	//	// console.log('/Admin/Noticias/ver/'+id);
		$http.get('Admin/Noticias/ver/'+id).
			success(function(data, status, headers, config) {				
					data.estatus=data.estatus=='1';
					//// console.log(data);
					$scope.alerta_nueva=data;					
					//// console.log($scope.alerta_nueva);
					var $j = jQuery.noConflict();
	                $j("#modificar_noticia").modal("show");				
			}).
			error(function(data, status, headers, config) {
				// console.log("getAlerta");
				// console.log(status);
				hacerToast('error','Error '+status,$mdToast);
			});
	}
		$scope.recargar=function(){
			$scope.paginador.valor=!$scope.paginador.valor;
		}


	$scope.getResource = function (params, paramsObj) {	
		if(!paramsObj){
			// console.log('Cambio  de Asignacion');
			paramsObj=$scope.paginador;
			// console.log(paramsObj);
		}

	
		$scope.paginador=paramsObj;
	//	// console.log('Antes de la Carga Inicial');
		// console.log($scope.paginador);

		var urlApi = 'Admin/noticias/tabla_principal_noticias/'+paramsObj.count+'/'+paramsObj.page+'/';
	
		if(paramsObj.sortBy){
			urlApi+=paramsObj.sortBy+'/'+paramsObj.sortOrder;    
		}

		return $http.post(urlApi,$scope.busqueda).then(function (response) {
			// console.log(response);
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



	$scope.registrar_alerta=function(){	
		var url='',  obj={};obj2={};aux={'detalle':'','estatus':'','fechahora':'','idevento':'','idubicacion':'','titulo':'','usuario':''};
			url='Admin/noticias/modificar_noticias';

			obj=$scope.alerta_nueva;
			obj2=$scope.alerta_nueva;
			if(obj["estatus"]){
				obj["estatus"]=1;
			}else{
				obj["estatus"]=0;
			
			}
				aux['detalle']=obj['detalle'];
				aux['usuario']=obj['usuario'];
				aux['fechahora']=obj['fechahora'];
				aux['idevento']=obj['idevento'];
				aux['idubicacion']=obj['idubicacion'];
				aux['titulo']=obj['titulo'];
               // aux['foto']=obj['foto'];
				aux['estatus']=obj['estatus'];	
			
			delete obj['idubicacion'];
            delete obj['foto'];
        
         console.log("sock");
        console.log(obj);
         console.log("bdd");
        console.log(aux);
        
			ws.send(JSON.stringify(obj));
			
					
		$scope.submitted = true;
			$http.post(url, aux).
			success(function(data, status, headers, config) {
				if(data.estatus){
					hacerToast('success',data.mensaje,$mdToast);

					$scope.recargar();
				}else
					hacerToast('error',data.mensaje,$mdToast);   
			}).
			error(function(data, status, headers, config) {
				//// console.log(data);
				hacerToast('error','Error '+status,$mdToast);
			});
		

	};

}
 