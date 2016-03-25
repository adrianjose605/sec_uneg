
<div ng-controller="noticias" layout="column" flex id="content" >
    <div class="container" style="width:95%">
        <h1 >Alertas</h1>

        <h3>Busqueda</h3>

            <form class="form-inline" name="formBusquedaPais" role="form" novalidate>
                <div class="form-group">
                    <md-input-container flex>
                        <label>Nombre / Abrev</label>
                        <input ng-model="busqueda.query" name="query_busqueda" type="text">                
                    </md-input-container>            
                </div>

                <div class="form-group">
                    <md-switch ng-model="busqueda.estatus" ng-change="recargar()">
                        Solo Activos
                    </md-switch>
                </div>

                <div class="form-group">    
                    <md-button id="buscar" class="md-raised md-primary" ng-click="recargar()">Buscar</md-button>
                </div>
            
                
            </form>




            <div ng-show="contador != 0" tasty-table bind-resource-callback="getResource" bind-filters="paginador">
                <table class="table table-striped table-condensed" >
                    <thead tasty-thead bind-not-sort-by="notSortBy" class="centrado"></thead>
                    <tbody id="tabla">
                        <tr ng-repeat="row in rows" class="centrado">

                            <td>{{ row.Usuario}}</td>
                            <td>{{ row.Titulo}}</td>
                            <td>{{ row['Enviado']}}</td>                
                            <td><span class="glyphicon" ng-class="( (row.Estatus==1) ? 'mdi-action-done activo' : 'mdi-action-highlight-remove inactivo')" aria-hidden="true" title="ACTIVO" style="color:green"></span></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-material-cyan btn-xs" href=""  ng-click="getAlerta(row.Opciones)" data-toggle="modal" data-target="#modificar_noticia"><span class="glyphicon glyphicon-search"></span></a>
                                </div>
                            </td>

                        </tr>
                    </tbody>
                </table>
                <div tasty-pagination></div>
            </div>

          


            <!--MODAL DE EDICION-->
            <div id="modificar_noticia" class="modal fade" >
                <div class="modal-dialog modal-wide-md">
                    <!-- Modal content-->
                    <div class="modal-content ">
                        <div class="modal-header">
                            <button type="button" class="close" ng-click="resetForm();" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Alerta Recibida</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-inline" name="formNoticiaM" role="form" novalidate>
                                <div class="form-group">
                                    <md-input-container flex>
                                        <label>Usuario</label>
                                        <input ng-model="alerta_nueva.usuario"  ng-readonly="true" pattern="^[a-zA-Z0-9áéíóúñ_]+( [a-zA-Z0-9áéíóúñ _]+)*$" name="usuario_noticia" type="text">

                                    </md-input-container>
                                </div>
                                <div class="form-group">
                                    <md-input-container flex>
                                        <label>Titulo</label>
                                        <input maxlength="3" ng-model="alerta_nueva.titulo" ng-readonly="true" pattern="[a-zA-Z]+" type="text" name="titulo_noticia">
                                        <ng-messages for="formNoticiaM.usuario_noticia.$error" role="alert" ng-if="submitted">
                                            <ng-message when="required">Debe indicar un Titulo</ng-message>
                                            <ng-message when="pattern">El titulo deben ser caracteres</ng-message>  
                                        </ng-messages>

                                    </md-input-container>
                                </div>
                                   <div class="form-group">
                                    <md-input-container flex>
                                        <label>Detalle</label>
                                        <input ng-model="alerta_nueva.detalle"  ng-readonly="true" pattern="^[a-zA-Z0-9áéíóúñ_]+( [a-zA-Z0-9áéíóúñ _]+)*$" name="detalle_noticia" type="text">

                                    </md-input-container>
                                </div>
                                <div class="form-group">
                                    <md-input-container flex>
                                        <label>Fecha de Registro</label>
                                        <input ng-model="alerta_nueva.fechahora" ng-readonly="true"   name="fechahora">                            
                                    </md-input-container>
                                </div>
                                <div class="form-group">
                                    <md-input-container flex>
                                        <label>Ubicacion</label>
                                        <input ng-model="alerta_nueva.ubicacion" ng-value="alerta_nueva.idubicacion"  ng-readonly="true" pattern="^[a-zA-Z0-9áéíóúñ_]+( [a-zA-Z0-9áéíóúñ _]+)*$" name="ubicacion_noticia" type="text">

                                    </md-input-container>
                                </div>
                                <div class="form-group">
                                    <md-switch ng-model="alerta_nueva.estatus">
                                        Activo
                                    </md-switch>
                                </div>
                                <div class="form-group center">
                                  
                                <img data-ng-src="data:image/jpg;base64,{{alerta_nueva.foto}}"  style="max-width: 640px; max-height: 480px"  data-err-src="<?php echo base_url(); ?>public/img/angular.png"/>
                                </div>

                            </form>
                            <div class="modal-footer">
                                <md-button class="md-raised md-primary" ng-click="registrar_alerta()">Guardar</md-button>

                                <md-button ng-click="resetForm();" data-dismiss="modal">Cerrar</md-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>


</div>

<div  ng-controller="List" id='#mes'>
   
</div>

<script src="<?php echo base_url(); ?>public/js/websocket.js"></script>

<script src="<?php echo base_url(); ?>public/js/Administrador/Noticias.js"></script>










