<?php

namespace julio101290\boilerplateslicences\Models;
use CodeIgniter\Model;

class LicenciasModel extends Model {

    protected $table = 'licencias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'idEmpresa', 'descripcion', 'desdeFecha', 'hastaFecha', 'claveModulo', 'licencia', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = [
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

public function mdlGetLicencias($idEmpresas)
{
    $result = $this->db->table('licencias a')
        ->select(
            'a.id,
             a.idEmpresa,
             a.descripcion,
             a.desdeFecha,
             a.hastaFecha,
             a.claveModulo,
             b.nombre AS nombre,
             b.rfc,
             a.licencia,
             a.created_at,
             a.updated_at,
             a.deleted_at,
             b.nombre AS nombreEmpresa'
        )
        ->join('empresas b', 'a.idEmpresa = b.id') // JOIN explícito
        ->whereIn('a.idEmpresa', $idEmpresas);

    return $result;
}

    /**
     * Obtenemos licencia espeficica
     */
public function mdlObtenerLicencia($fecha, $modulo)
{
    $builder = $this->db->table('licencias l');

    $builder->select('descripcion, licencia, desdeFecha, hastaFecha');
    $builder->where('claveModulo', $modulo);
    $builder->where("'$fecha' >= desdeFecha", null, false); // comparación directa
    $builder->where("'$fecha' <= hastaFecha", null, false); // comparación directa

    $result = $builder->get()->getResultArray();

    return $result;
}
}
