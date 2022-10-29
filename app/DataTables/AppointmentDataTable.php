<?php

namespace App\DataTables;


use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AppointmentDataTable extends DataTable
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
            ->addColumn('action', function (Calendar $events) {
                return "<div class='table-data-feature'>
<a href='" . route('admin.calendar.show', $events->id) . "' class='item' data-toggle='tooltip' data-placement='top' data-original-title='Ver'>
<i class='fa fa-eye'></i>
</a>|
<a href='" . route('admin.calendar.edit', $events->id) . "' class='item' data-toggle='tooltip' data-placement='top' data-original-title='Editar'><i class='fa fa-edit'></i></a></div>";
            })
            ->addColumn('recurrence', function (Calendar $events) {
                return \App\Models\Calendar::RECURRENCE_RADIO[$events->recurrence] ?? '';
            })
            ->addColumn('start_time', function (Calendar $events) {
                return Carbon::parse($events->start_time)->format($this->formatDateTime) ?? '';
            })
            ->addColumn('end_time', function (Calendar $events) {
                return Carbon::parse($events->end_time)->format($this->formatDateTime) ?? '';
            })
            ->addColumn('lawyer', function (Calendar $events) {
                return $events->lawyer->name ?? '';
            })
            ->filterColumn('start_time', function ($query, $keyword) {
                return $query->where('start_time', Carbon::parse($keyword)) ?? '';
            })
            ->responsive(true)
            ->serverSide(true)
            ->searching(false)
            ->language('//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json')
            ->minifiedAjax()
//            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Calendar $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Calendar $model): QueryBuilder
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
            ->setTableId('appointmentdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('name','name')->title('Nome'),
            Column::make('start_time')->title('Hora de início'),
            Column::make('end_time')->title('Hora de Fim'),
            Column::make('recurrence')->title('Recorrência'),
            Column::make('address')->title('Endereço'),
            Column::make('lawyer')->title('Advogado'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Appointment_' . date('YmdHis');
    }
}
