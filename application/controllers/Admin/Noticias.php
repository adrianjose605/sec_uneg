<?php

class Noticias extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Noticias_model');
    }    
    
    /**
     * Creacion  de un nuevo pais
     */

    
    public function modificar_noticias(){
        echo json_encode($this->Noticias_model->edit_noticias());         
    }
    
    public function tabla_principal_noticias($count = 5, $page = 1, $order = 'Enviado', $type = 'dec'){
         if ($type != 'asc') {
            $type = 'desc';
        }
        $ret = array();
        $inicio = $page * $count - $count;
        $array = $this->Noticias_model->generar_json_tabla_principal($inicio, $count, $order, $type);

        if ($type != 'asc') {
            $type = 'dsc';
        }
        $cantidad_total = $array['cantidad'][0]['cantidad'] + 0;
        $paginas_totales = ceil($cantidad_total / $count);

        $result = $array['resultado'];

        $meta = $array['meta'];
        foreach ($result as $row) {
            $ret['rows'][] = $row;
        }

        foreach ($meta as $row) {
            $ret['header'][] = array_map('utf8_encode', array('name' => $row, 'key' => $row));
        }

        $ret['pagination'] = array('count' => $count, 'page' => $page, 'pages' => $paginas_totales, 'size' => $cantidad_total);

        $ret['sort-by'] = $order;
        $ret['sort-order'] = $type;

        echo json_encode($ret);
    }  
    
    public function ver ($id=1){             
        $result=$this->Noticias_model->get_noticias($id);
        foreach ($result as $row) {
            echo  (json_encode( $row));
            break;
        }
    }
        
    public function ver_sel($activos=true){        
        $res=array();
        $result = $this->Noticias_model->get_Noticias_sel($activos);
        foreach ($result as $row) {
            $res[]= $row;            
        }
        echo json_encode($res);        
    }
    

    public function index() {
        $data['nombre'] = 'name';
        $data['title'] = 'SecUneg';
    
 if (!$this->session->userdata('logueado')) {

                redirect('usuarios/personas');
        } else{

            $this->load->model('Usuarios_model');
            $p=$this->Usuarios_model->comprobar_permisos($this->session->userdata('permiso'));
         if($p->ver_noticias==1){  
       $this->load->view('templates/header', $data);
        $this->load->view('navbars/admin', $data);
        $this->load->view('Admin/Noticias', $data);     
        $this->load->view('templates/footer', $data); 
        }else{
            redirect('Usuarios/personas');

                }        


        }



       
    }
    
}
