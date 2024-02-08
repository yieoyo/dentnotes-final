<?php

namespace App\DataTables;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RolesDataTable extends DataTable
{

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))->setRowId('id')->addColumn('action', 'role.action');
    }


    public function query(Role $model): QueryBuilder
    {

        $query = $model->newQuery();


        if (request()->input('show_deleted')) {
            $query = $query->onlyTrashed();
        } else {
            $query = $query->withoutTrashed();
        }

        return $query;
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()->setTableId('roles-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->orderBy(1)
        ->selectStyleSingle()
        ->responsive(true)
        ->buttons([
            Button::make('add'),
            Button::make('excel'),
            Button::make('csv'),

            Button::make('print'),
            Button::make('reset'),
            Button::make('reload'),
        ]);
    }


    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('deleted_at'),
            Column::computed('action')
            ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }


    protected function filename(): string
    {
        return 'Roles_' . date('YmdHis');
    }
}
