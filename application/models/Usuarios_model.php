<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }


     function comprobar_permisos($idpermiso){
        $this->db->select('*');
        $this->db->from('permisos');
        $this->db->where('id',$idpermiso);
        $result= $this->db->get();
       
        return $result->row();

    }


    function login($usuario, $clave){
        $query="call iniciar_sesion('$usuario', '$clave')";
        $result=$this->db->query($query);

        return $result->result_array();

    }


    function acceso($data){
        $this->db->select('*');
        $this->db->where('usuario',$data['usuario']);
        $result= $this->db->get('usuarios');
        $user= $result->row();


        if(isset($user)){
        $this->db->select('*');
        $this->db->where('usuario',$data['usuario']);
        $this->db->where('pass',$data['clave']);
       $result= $this->db->get('usuarios');
      return $result->row();
        }else{

        return NULL; 
        };
       
       

    }
    function verificacion() {
        $data = $this->getInputFromAngular();
        $usuario = array('nombre' => $data('nom'),
            'nombre' => $data('nom'),
            'usuario' => $data('us'),
            'ventas' => $data('p1'),
            'reportes' => $data('p2'),
            'registro' => $data('p3'),
            'clave' => $data('pass'),);
        $this->db->where('usuario', $usuario['usuario']);
        $query = $this->db->get('usuario_sistema');

        if ($query->row()) {

            if ($query->row()->clave == $usuario['clave']) {

                return 1;
            } else {

                return 2;
            }
        } else {

            return 3;
        }
    }

    public function crear() {
        $data = $this->getInputFromAngular();
        $usuario = [];
        $usuario = ['nombre' => $data['nom'],
            'usuario' => $data['us'],
            'ventas' => $data['p1'],
            'reportes' => $data['p2'],
            'registros' => $data['p3'],
            'clave' => md5($data['pass']),
            'telefono'=> $data['tlfn']];


        $this->db->insert('usuario_sistema', $usuario);
    }

    public function modificar() {
        $data = $this->getInputFromAngular();
        $usuario = [];
        $usuario = [
            'nombre' => $data['nom'],
            'ventas' => $data['p1'],
            'reportes' => $data['p2'],
            'registros' => $data['p3'],
            'clave' => md5($data['pass']),
            'telefono'=> $data['tlfn']];
        
        $this->db->where('usuario', $usuario['usuario']);
        $this->db->update('usuario_sistema', $usuario);

        $this->db->update('usuario_sistema', $usuario);
    }

    public function consultar() {
        $data = $this->getInputFromAngular();
        $usuario = [];
        $usuario = ['nombre' => $data['nom'],
            'ventas' => $data['p1'],
            'reportes' => $data['p2'],
            'registros' => $data['p3'],
            'clave' => md5($data['pass'])];


        $this->db->insert('usuario_sistema', $usuario);
    }



 public function get_usuarios($id) {
        $this->db->select('idevento,usuario,titulo,fechahora,detalle,ubicacion,foto,estatus');
        $this->db->where('idevento', $id);
        $query = $this->db->get('evento');
        return $query->result_array();
    }

    public function get_Grupo($id) {
        $this->db->select('ver_noticias,enviar_noticias,boton_panico,crear_usuarios,permisos,estatus,descripcion,id');
        $this->db->where('id', $id);
        $query = $this->db->get('permisos');
        return $query->result_array();
    }
    
    
    public function get_usuarios_sel($activos=false){
        $this->db->select('idevento  AS id,usuario AS val');
         
        if ($activos)
            $this->db->where('estatus', $activos);
        
        $query = $this->db->get('tbpais');
        return $query->result_array();
    }




    public function generar_json_tabla_grupos($offset, $cantidad, $order, $type) {
        $arr = $this->getInputFromAngular();
        $params = preg_split('#\s+#', trim($arr['query']));
        $w = false;
        if ($arr['estatus'])
            $this->db->where('estatus', $arr['estatus']);
        $likes = '';


        for ($i = 0; $i != count($params); $i++) {
            if ($i == 0)
                $likes.="( descripcion LIKE '%" . $params[$i] . "%'";
            else
                $likes.="OR descripcion LIKE '%" . $params[$i] . "%'";
            if ($i + 1 == count($params))
                $likes.=")";
        }

        if (!empty($likes))
            $this->db->where($likes);


        $this->db->select('COUNT(1) AS cantidad');


        $query1 = $this->db->get('permisos');
        $respuesta['cantidad'] = $query1->result_array();

        $this->db->select('descripcion AS Descripcion,ver_noticias AS Ver_Alertas, enviar_noticias  AS Enviar_Alertas,boton_panico AS Boton_Panico,crear_usuarios AS Crear_U,permisos AS Crear_Permisos , estatus AS Estatus, id AS Opciones');
        if ($arr['estatus'])
            $this->db->where('estatus', $arr['estatus']);
        if (!empty($likes))
            $this->db->where($likes);


        $this->db->limit($cantidad, $offset);
       $this->db->order_by($order, $type);

        $query = $this->db->get('permisos');
        $respuesta['resultado'] = $query->result_array();
        $respuesta['meta'] = $query->list_fields();
        

        return $respuesta;
    }



    public function generar_json_tabla_principal($offset, $cantidad, $order, $type) {
        $arr = $this->getInputFromAngular();
        $params = preg_split('#\s+#', trim($arr['query']));
        $w = false;
        if ($arr['estatus'])
            $this->db->where('estatus', $arr['estatus']);
        $likes = '';


        for ($i = 0; $i != count($params); $i++) {
            if ($i == 0)
                $likes.="(usuario LIKE '%" . $params[$i] . "%' OR nombre LIKE '%" . $params[$i] . "%'";
            else
                $likes.="OR usuario LIKE '%" . $params[$i] . "%' OR nombre LIKE '%" . $params[$i] . "%'";
            if ($i + 1 == count($params))
                $likes.=")";
        }

        if (!empty($likes))
            $this->db->where($likes);


        $this->db->select('COUNT(1) AS cantidad');


        $query1 = $this->db->get('usuarios');
        $respuesta['cantidad'] = $query1->result_array();

        $this->db->select('usuario AS Usuario,titulo AS Titulo,fechahora AS Enviado,estatus AS Estatus,idevento AS Opciones');
        if ($arr['estatus'])
            $this->db->where('estatus', $arr['estatus']);
        if (!empty($likes))
            $this->db->where($likes);


        $this->db->limit($cantidad, $offset);
        $this->db->order_by($order, $type);

        $query = $this->db->get('usuarios');
        $respuesta['resultado'] = $query->result_array();
        $respuesta['meta'] = $query->list_fields();
        return $respuesta;
    }

    public function edit_usuarios() {
        $res = array();
        $arr = $this->getInputFromAngular();
         
        
        $this->db->where('idevento', $arr['idevento']);        
        
        if ($this->db->update('evento', $arr)) {
            $res['status'] = 1;
            $res['mensaje'] = 'Actualizado con Exito';
        } else {
            $res['status'] = 0;
            $res['mensaje'] = 'Ocurrio un Problema al Actualizar';
        }
        return $res;
    }
     public function edit_grupos() {
        $res = array();
        $arr = $this->getInputFromAngular();
         
        
        $this->db->where('id', $arr['id']);        
        
        if ($this->db->update('permisos', $arr)) {
            $res['status'] = 1;
            $res['mensaje'] = 'Actualizado con Exito';
        } else {
            $res['status'] = 0;
            $res['mensaje'] = 'Ocurrio un Problema al Actualizar';
        }
        return $res;
    }

    public function insert_usuarios() {
        $arr = $this->getInputFromAngular();
        $res = array();
        $this->db->select('nombre');
        $this->db->where('nombre', $arr['nombre']);
        $query1 = $this->db->get('usuarios');
        if ($query1->num_rows() > 0) {
            $res['status'] = 0;
            $res['mensaje'] = 'El pais ya se encuentra registrado';
            return $res;
        }

        $this->db->select('abreviatura');
        $this->db->where('abreviatura', $arr['abreviatura']);
        $query1 = $this->db->get('tbpais');
        if ($query1->num_rows() > 0) {
            $res['status'] = 0;
            $res['mensaje'] = 'La abreviatura ya se encuentra registrada con otro pais';
            return $res;
        }

        $this->db->set('fecha_registro', 'NOW()', FALSE);

        if ($this->db->insert('tbpais', $arr)) {
            $res['status'] = 1;
            $res['mensaje'] = 'Registrado con Exito';
        } else {
            $res['status'] = 0;
            $res['mensaje'] = 'Error Desconocido';
        }

        return $res;
    }
     public function insert_grupo() {
        $arr = $this->getInputFromAngular();
        $res = array();
        $this->db->select('descripcion');
        $this->db->where('descripcion', $arr['descripcion']);
        $query1 = $this->db->get('permisos');
        if ($query1->num_rows() > 0) {
            $res['status'] = 0;
            $res['mensaje'] = 'El grupo ya se encuentra registrado';
            return $res;
        }

       
       
        if ($this->db->insert('permisos', $arr)) {
            $res['status'] = 1;
            $res['mensaje'] = 'Registrado con Exito';
        } else {
            $res['status'] = 0;
            $res['mensaje'] = 'Error Desconocido';
        }

        return $res;
    }




}

?>