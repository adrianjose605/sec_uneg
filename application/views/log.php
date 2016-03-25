
<div   style="height: 450px; width: 400px;">
    <md-toolbar layout="row"  >
        <div class="md-toolbar-tools">
            <center><h1>Bienvenido a SecUNEG</h1></center>
        </div>
    </md-toolbar>
   
        <div   style="margin-top: 30px;" >
        <md-content layout-padding>
           <form method="post" action="usuarios/verificacion"  name="formSesion" role="form" novalidate>


                    <md-input-container style="margin-top: 6%; width: 95%;"class="" >
                        <label>Usuario</label>
                        <input required md-no-asterisk name="usuario" ng-model="user.usuario">
                    </md-input-container><br>
                    <md-input-container class=""  style="width:  95%;">
                        <label>Contraseña</label>
                        <input required name="clave"  ng-model="user.clave" type="password">
                    </md-input-container><br>

                    <md-button style="margin-top: 28%; margin-left: 35%;" type="submit" class="md-raised md-primary" >Ingresar</md-button>

                    <md-button class="md-fab  md-primary" style="margin-left: 20%" href="<?php echo base_url(); ?>usuarios/personas" >
                        <md-icon class="center" md-svg-src="public/icons/formas.svg" style="margin-top: 33%"></md-icon>
                    </md-button>
                        <div flex layout="row"></div><div flex></div><div flex></div>
               
             


            </form>
            </md-content>

        </div>
     <center></center>
   
</div>



