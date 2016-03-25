<md-toolbar layout="row"  class="md-theme-indigo">
    <div class="md-toolbar-tools">
        <md-button ng-click="toggleSidenav('left')" class="md-icon-button">
            <span class="glyphicon glyphicon-align-justify"></span>
        </md-button>
        <h1>SecUneg 2016</h1>
    </div>
</md-toolbar>
<div layout="row" flex>
    <md-sidenav layout="column" class="md-sidenav-left md-whiteframe-z2" md-component-id="left">
        <md-content layout-padding="">
            <accordion close-others="oneAtATime">
                <accordion-group>
                    <accordion-heading>
                        <p><span class="glyphicon glyphicon-menu-down" style="margin-right: 10px;"></span> Configuracion de Parametros</p>
                    </accordion-heading> 
                    <md-list class="listdemoListControls">
                    <h2 class="md-no-sticky md-subheader md-default-theme"><div class="md-subheader-inner"><span class="md-subheader-content"><span class="ng-scope">Monitorizacion</span></span></div></h2>
                        <md-list-item ng-click="navigateTo('Admin/noticias')">
                            <p><span class="glyphicon glyphicon-menu-right" style="margin-right: 10px;"></span> Alertas</p>
                        </md-list-item>
                       
                   
                      
                       
                    <md-divider class="md-default-theme"></md-divider>
                </accordion-group>
                <accordion-group>
                    <accordion-heading>
                        <p><span class="glyphicon glyphicon-menu-down" style="margin-right: 10px;"></span> Manejo de Personal</p>
                    </accordion-heading> 
                    <md-list class="listdemoListControls">
                        <md-list-item ng-click="navigateTo('User/GUsuarios')">
                            <p><span class="glyphicon glyphicon-menu-right" style="margin-right: 10px;"></span> Gestion de Permisos</p>
                        </md-list-item>
                        
                        <md-list-item ng-click="navigateTo('Person/usuarios')">
                            <p><span class="glyphicon glyphicon-menu-right" style="margin-right: 10px;"></span> Control de Usuarios</p>
                        </md-list-item>
                    </md-list>

                </accordion-group>
                
            </accordion>
        </md-content>
    </md-sidenav>
