<?php

/**
 * Description of Pais
 *
 * @author zyos
 */
class Noticias_model extends CI_Model {

//put your code here
    public function __construct() {
        $this->load->database();
        
    }
//
//    public function get_prueba() {
//        $query = $this->db->get('par_subproductos');
//        return $query->result_array();
//    }

    public function get_noticias($id) {
        $this->db->select('idevento,usuario,titulo,fechahora,detalle,ubicacion.descripcion ubicacion,foto,estatus, idubicacion');
        $this->db->where('idevento', $id);
        $this->db->where('evento.idubicacion=ubicacion.id');
        $query = $this->db->get('evento, ubicacion');
        return $query->result_array();
    }
    
    public function get_noticias_sel($activos=false){
        $this->db->select('idevento  AS id,usuario AS val');
         
        if ($activos)
            $this->db->where('estatus', $activos);
        
        $query = $this->db->get('tbpais');
        return $query->result_array();
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
                $likes.="(usuario LIKE '%" . $params[$i] . "%' OR titulo LIKE '%" . $params[$i] . "%'";
            else
                $likes.="OR usuario LIKE '%" . $params[$i] . "%' OR titulo LIKE '%" . $params[$i] . "%'";
            if ($i + 1 == count($params))
                $likes.=")";
        }


        if (!empty($likes))
            $this->db->where($likes);
           
        $this->db->select('COUNT(1) AS cantidad');


        $query1 = $this->db->get('evento');
        $respuesta['cantidad'] = $query1->result_array();

        $this->db->select('evento.usuario AS Usuario,evento.titulo AS Titulo,evento.fechahora AS Enviado,evento.estatus AS Estatus,idevento AS Opciones');

        if ($arr['estatus'])
            $this->db->where('evento.estatus', $arr['estatus']);
        
        

        $this->db->limit($cantidad, $offset);
        $this->db->order_by($order, $type);

        $query = $this->db->get("evento");
        $respuesta['resultado'] = $query->result_array();
        $respuesta['meta'] = $query->list_fields();
        return $respuesta;
    }

    public function edit_noticias() {
        $res = array();
        $arr = $this->getInputFromAngular();
         
        
        $this->db->where('idevento', $arr['idevento']);        
        
        if ($this->db->update('evento', $arr)) {
            $res['estatus'] = 1;
            $res['mensaje'] = 'Actualizado con Exito';
        } else {
            $res['estatus'] = 0;
            $res['mensaje'] = 'Ocurrio un Problema al Actualizar';
        }
        return $res;
    }

    public function insert_noticias() {
        $arr = $this->getInputFromAngular();
        $res = array();
        $this->db->select('nombre');
        $this->db->where('nombre', $arr['nombre']);
        $query1 = $this->db->get('tbpais');
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

}
