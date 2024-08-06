<?php
namespace App\Models;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Support\Str;

class Permission extends SpatiePermission
{
    const PERMISSION_DETAIL = [
        'administrar-clientes' => 'Puede ver, crear y editar clientes',
        'administrar-contratistas' => 'Puede ver, crear y editar contratistas',
        'administrar-especialidades' => 'Puede ver, crear y editar especialidades de presupuestos',
        'administrar-materiales' => 'Puede ver, crear y editar materiales',
        'administrar-preconceptos' => 'Puede ver, crear y editar pre-conceptos',
        'administrar-presupuestos' => 'Puede crear y editar presupuestos pero NO editar factores',
        'administrar-permisos' => 'Puede ver, crear y editar roles y permisos de los usuarios',
        'administrar-proveedores' => 'Puede ver, crear y editar proveedores',
        'administrar-proyectos' => 'Puede crear y editar proyectos pero NO generar/autorizar solicitudes, ni ordenes de compra',
        'administrar-usuarios' => 'Puede ver, crear y editar usuarios pero NO editar roles ni permisos',
        'autorizar-orden-compra' => 'Puede crear y autorizar ordenes de compra',
        'autorizar-solicitud-compra' => 'Puede crear y autorizar solicitudes de compra',
        'crear-orden-compra' => 'Puede crear ordenes de compra pero NO autorizarlas',
        'crear-solicitud-compra' => 'Puede crear solicitudes de compra pero NO autorizarlas',
        'editar-factores' => 'Puede editar factores y descuento',
        'monitor-compras' => 'Puede despachar ordenes de compra pero NO crearlas ni autorizarlas',
        'tickets-soporte' => 'Puede ver y crear tickets de soporte técnico',
        'ver-clientes' => 'Puede ver clientes pero no crearlos o editarlos',
        'ver-contratistas' => 'Puede ver contratistas pero no crearlos o editarlos',
        'ver-materiales' => 'Puede ver el catalogo de materiales pero no crearlos o editarlos',
        'ver-presupuestos' => 'Puede ver el catalogo de presupuestos y visualizar PDF',
        'ver-proveedores' => 'Puede ver proveedores pero no crearlos o editarlos',
        'ver-proyectos' => 'Puede ver el catalogo de proyectos',
        'enviar-pedidos' => 'Puede enviar pedidos a proveedores por correo',
        'reporte-finanzas' => 'Puede ver reportes de finanzas',
        'admin-personal-administrativo' => 'Puede ver, crear y editar personal administrativo',
        'reporte-comisiones' => 'Puede ver reportes de comisiones',
        'gastos-fijos' => 'Puede ver y crear gastos fijos',
        'reporte-facturas' => 'Puede ver reportes de facturas',
        'registrar-entrada' => 'Puede registrar entradas',
        'administrar-entradas' => 'Puede ver, crear y editar entradas',
        'reporte-depositos' => 'Puede ver reportes de depositos',
        'gastos-generales' => 'Puede ver y crear gastos generales',
        'registrar-entrada' => 'Puede registrar entradas',
        'vehiculos-entregados' => 'Puede ver vehiculos entregados',
        'administrar-personal' => 'Puede ver, crear y editar personal',
        'diagrama-nomina' => 'Puede ver diagrama de nomina',
        'servicio-flotillas' => 'Puede ver servicio de flotillas',
        'administrar-catalogos' => 'Puede ver, crear y editar catalogos',


    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->name = Str::slug($model->name);
        });
    }

    public function getNameFormatAttribute(){
        return strtoupper(str_replace('-', ' ', $this->attributes['name']));
    }
}