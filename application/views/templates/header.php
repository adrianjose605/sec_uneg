<html ng-app="secuneg">
    <head>
    <meta charset="UTF-8">

        <base href="<?php echo base_url() ?>">
        <title>SecUneg</title>
        <link rel="stylesheet" href="public/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/angular-material/angular-material.min.css">
        <link rel="stylesheet" href="public/bootstrap-material-design/css/material.min.css">
        <link rel="stylesheet" href="public/bootstrap-material-design/css/ripples.min.css">
        <link rel="stylesheet" href="public/bootstrap-material-design/css/roboto.min.css">
        <link rel="stylesheet" href="public/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="public/css/general.css">
        <link rel="stylesheet" href="public/material-icon/css/materialdesignicons.min.css">        
        <link rel="stylesheet" href="public/angular-datepicker-master/dist/index.min.css">
        <link rel="stylesheet" href="public/bootstrap-timepicker/less/timepicker.less">



        <script src="public/jquery/jquery.min.js"></script>
        <script src="public/angular/angular.min.js"></script>
        <script src="public/moment/moment.js"></script>
        <script src="public/angular-aria/angular-aria.min.js"></script>
        <script src="public/angular-animate/angular-animate.min.js"></script>
        <script src="public/angular-messages/angular-messages.min.js"></script>
        <script src="public/angular-datepicker-master/dist/index.min.js"></script>
        <script src="public/bootstrap-material-design/js/material.min.js"></script>
        <script src="public/bootstrap-material-design/js/ripples.min.js"></script>
        <script src="public/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="public/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
        <script src="public/angular-material/angular-material.min.js"></script>

        <script src="public/ng-tasty/ng-tasty-tpls.min.js"></script>
        <script src="public/angular-bootstrap-ui/ui-bootstrap.min.js"></script>

        <script src="public/js/Sec_uneg.js"></script>
        


 
        <script>
            $(document).ready(function () {
                $.material.init();
            });

            var base_url = '<?php echo base_url(); ?>';
        </script>
        <style>
            .md-toolbar-tools h1 {
                font-size: inherit;
                font-weight: inherit;
                margin: inherit;
            }
            .listdemoListControls md-divider {
                margin-top: 10px;
                margin-bottom: 10px; }

        </style>



    </head>
    <body layout="column" ng-controller="AppCtrl">
