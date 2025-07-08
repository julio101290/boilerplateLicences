<?php

namespace julio101290\boilerplatelicences\Controllers;

use App\Controllers\BaseController;
use julio101290\boilerplatelicences\Models\{
    LicenciasModel
};
use julio101290\boilerplatelog\Models\LogModel;
use CodeIgniter\API\ResponseTrait;
use julio101290\boilerplatecompanies\Models\EmpresasModel;

class LicenciasController extends BaseController {

    use ResponseTrait;

    protected $log;
    protected $licencias;
    protected $empresa;

    public function __construct() {
        $this->licencias = new LicenciasModel();
        $this->log = new LogModel();
        $this->empresa = new EmpresasModel();
        helper('menu');
        helper('utilerias');
    }

    public function index() {



        helper('auth');

        $idUser = user()->id;
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }




        if ($this->request->isAJAX()) {
            $datos = $this->licencias->mdlGetLicencias($empresasID);

            return \Hermawan\DataTables\DataTable::of($datos)->toJson(true);
        }
        $titulos["title"] = lang('licencias.title');
        $titulos["subtitle"] = lang('licencias.subtitle');
        return view('julio101290\boilerplatelicences\Views\licencias', $titulos);
    }

    /**
     * Read Licencias
     */
    public function getLicencias() {

        helper('auth');

        $idUser = user()->id;
        $titulos["empresas"] = $this->empresa->mdlEmpresasPorUsuario($idUser);

        if (count($titulos["empresas"]) == "0") {

            $empresasID[0] = "0";
        } else {

            $empresasID = array_column($titulos["empresas"], "id");
        }


        $idLicencias = $this->request->getPost("idLicencias");
        
        $datosLicencias = $this->licencias->whereIn('idEmpresa', $empresasID)
                        ->where("id", $idLicencias)->first();
        
        /**
         * Obtenemos los datos de la empresa
         * 
         */
        
        $datosEmpresa = $this->empresa->find($datosLicencias["idEmpresa"]);
        
        $datosLicencias["nombre"] = $datosEmpresa["nombre"];
        $datosLicencias["direccion"] = $datosEmpresa["direccion"];
        $datosLicencias["rfc"] = $datosEmpresa["rfc"];
        $datosLicencias["telefono"] = $datosEmpresa["telefono"];
        $datosLicencias["correoElectronico"] = $datosEmpresa["correoElectronico"];
        $datosLicencias["diasEntrega"] = $datosEmpresa["diasEntrega"];
        $datosLicencias["razonSocial"] = $datosEmpresa["razonSocial"];
        $datosLicencias["codigoPostal"] = $datosEmpresa["codigoPostal"];
        $datosLicencias["CURP"] = $datosEmpresa["CURP"];
        
        echo json_encode($datosLicencias);
        
        
    }

    /**
     * Save or update Licencias
     */
    public function save() {
        helper('auth');
        $userName = user()->username;
        $idUser = user()->id;
        $datos = $this->request->getPost();
        if ($datos["idLicencias"] == 0) {
            try {
                if ($this->licencias->save($datos) === false) {
                    $errores = $this->licencias->errors();
                    foreach ($errores as $field => $error) {
                        echo $error . " ";
                    }
                    return;
                }
                $dateLog["description"] = lang("vehicles.logDescription") . json_encode($datos);
                $dateLog["user"] = $userName;
                $this->log->save($dateLog);
                echo "Guardado Correctamente";
            } catch (\PHPUnit\Framework\Exception $ex) {
                echo "Error al guardar " . $ex->getMessage();
            }
        } else {
            if ($this->licencias->update($datos["idLicencias"], $datos) == false) {
                $errores = $this->licencias->errors();
                foreach ($errores as $field => $error) {
                    echo $error . " ";
                }
                return;
            } else {
                $dateLog["description"] = lang("licencias.logUpdated") . json_encode($datos);
                $dateLog["user"] = $userName;
                $this->log->save($dateLog);
                echo "Actualizado Correctamente";
                return;
            }
        }
        return;
    }

    /**
     * Delete Licencias
     * @param type $id
     * @return type
     */
    public function delete($id) {
        $infoLicencias = $this->licencias->find($id);
        helper('auth');
        $userName = user()->username;
        if (!$found = $this->licencias->delete($id)) {
            return $this->failNotFound(lang('licencias.msg.msg_get_fail'));
        }
        $this->licencias->purgeDeleted();
        $logData["description"] = lang("licencias.logDeleted") . json_encode($infoLicencias);
        $logData["user"] = $userName;
        $this->log->save($logData);
        return $this->respondDeleted($found, lang('licencias.msg_delete'));
    }

    public function ctrValidarLicencia($cadena, $fecha, $claveModulo) {

        //$encriptarCadena = sha1($cadena . "degreelessnessModeOn");
        
        $encriptarCadena = sha1($cadena . "DegreeLessnessMode_On");

        $licencia = $this->licencias->mdlObtenerLicencia($fecha, $claveModulo);

        if (count($licencia) == 0) {

            return false;
        }
        $licencia = $licencia[0]["licencia"];

        if ($encriptarCadena == $licencia) {

            return true;
        } else {

            return false;
        }
    }
}
