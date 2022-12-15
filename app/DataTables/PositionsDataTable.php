<?php

namespace App\DataTables;

use App\Models\Positions;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\ButtonsServiceProvider;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Options\Plugins\Buttons;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Carbon;

class PositionsDataTable extends DataTable
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
            ->addColumn('action', function ($row){
                $html = '<a href="'. route("positions.edit", $row->id) . '" class="btn btn-xs btn-secondary">Edit</a> ';
                $html .= '<button data-rowid="'.$row->id.'" class="destroy btn btn-xs btn-danger">Del</button>';
                return $html;
            })
            ->setRowId('id')->editColumn('updated_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->format('d.m.y'); return $formatedDate; });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Positions $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Positions $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('positions-table')
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
            Column::make('name'),
            Column::make('updated_at'),
            Column::make('action')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Positions_' . date('YmdHis');
    }
}
