
angular.module('Transporte')
  .controller('User', function ($scope, $log, $http, $mdToast) {
      $scope.obj={};
     
      $scope.boton1="Guardar";
      $scope.paginador={valor:true};
      $scope.recargar=function(){
		$scope.paginador.valor=!$scope.paginador.valor;
	}
        $scope.hacerToast = function() {
    $mdToast.show(
      $mdToast.simple()
        .textContent('Simple Toast!')
        .position($scope.getToastPosition())
        .hideDelay(4000)
    );
  }
      $scope.user= function(tipo){
          
          var url='';

		if(tipo){
			url='/transporte/usuarios/insert_usuario';
                       	obj=$scope.obj;
                        
		}else{
			url='/transporte/usuarios/modif_usuario';
			obj=$scope.obj;
			
			

		}
                console.log('registrando');
                
               if ((tipo&&$scope.usuario_n.$valid)||(!tipo&&$scope.usuario_m.$valid)) { 
                   if(!obj['p1']){
                       obj['p1']=false;
                   }
                   if(!obj['p2']){
                       obj['p2']=false;
                   }
                   if(!obj['p3']){
                       obj['p3']=false;
                   }
                   console.log(obj);
                   console.log(url);
                $http.post(url, obj).
			success(function(data, status, headers, config) {
				if(data.status){
					hacerToast('success',data.mensaje,$mdToast);
					$scope.submitted=false;
				}
				else
					hacerToast('error',data.mensaje,$mdToast);

			}).
			error(function(data, status, headers, config) {
				console.log(status);
				hacerToast('error','Error '+status,$mdToast);
			});
      
          }else{
			$scope.submitted=true;  

		}
                $scope.recargar();
          };
      
      
      
      
      
      
  });