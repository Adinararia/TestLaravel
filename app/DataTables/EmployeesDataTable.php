<?php

namespace App\DataTables;

use App\Models\Employees;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->setRowId('id')
        ->editColumn('reception', function($data) {
            $formatedDate = Carbon::createFromFormat('Y-m-d', $data->reception)->format('d.m.y');
            return $formatedDate;
        })->editColumn('reception', function($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d', $data->reception)->format('d.m.y');
                return $formatedDate;
            })
            ->editColumn('positions.name', function($data) {
                return $data->position->name;
            })
            ->editColumn('image', function ($row){
                if($row->image) {
                    $url = asset($row->image);
                }else{
                    $url = asset('images/no_image.png');
                }
                $html = '<img src="'.$url.'" width="80" height="80">';
                return $html;
                })
            ->addColumn('action', function ($row){
                $html = '<a href="'. route("employees.edit", $row->id) . '" class="btn btn-xs btn-secondary">Edit</a> ';
                $html .= '<button data-rowid="'.$row->id.'" class="destroy btn btn-xs btn-danger">Del</button>';
                return $html;
            })->rawColumns(['image', 'action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employees $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employees $model): QueryBuilder
    {
        return $model->with('position')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('employees-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle();

    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('image'),
            Column::make('name'),
            Column::make('positions.name', 'position.id'),
            Column::make('reception'),
            Column::make('phone'),
            Column::make('email'),
            Column::make('salary'),
            Column::make('action'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Employees_' . date('YmdHis');
    }
}
