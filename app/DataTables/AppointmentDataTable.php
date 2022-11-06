<?php

namespace App\DataTables;


use App\Models\Calendar;
use App\Traits\CompanySessionTraits;
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
    use CompanySessionTraits;

    public $formatDateTime = 'd/m/Y H:i:s';
    public $cFormatDateTime = 'Y-m-d H:i:s';
    public $formatDate = 'd/m/Y';

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', fn($events) => $this->action($events))
            ->addColumn('recurrence', function (Calendar $events) {
                return Calendar::RECURRENCE_RADIO[$events->recurrence] ?? '';
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
            ->filterColumn('lawyer', function ($query, $keyword) {
                return $query->where('lawyer.name', 'LIKE', ["%{$keyword}%"]);
            })
//            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * @param Calendar $events
     * @return string
     */
    private function action(Calendar $events)
    {
        return "<div class='table-data-feature'>
<a href='" . route('admin.calendar.show', $events->pid) . "' class='item' data-toggle='tooltip' data-placement='top' data-original-title='Ver'>
<i class='fa fa-eye'></i>
</a>|
<a href='" . route('admin.calendar.edit', $events->pid) . "' class='item' data-toggle='tooltip' data-placement='top' data-original-title='Editar'><i class='fa fa-edit'></i></a></div>";

    }


    /**
     * @return QueryBuilder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function query(): QueryBuilder
    {
        $request = $this->request();
        if ($this->hasRole('admin')) {
            $events = Calendar::withCount('calendars');
        } else {
            $events = Calendar::withCount('calendars')
                ->with('lawyer')->whereCompanyId($this->getCompanyId());
        }

        if ($request->has('month') && !is_null($request->month)) {
            //Busca agendamentos por Mês
            $events->whereMonth('start_time', '=', $request->month);
        }
        if ($request->has('date') && !is_null($request->date)) {
            //Busca agendamentos por data
            $events->whereDate('start_time', '=', Carbon::createFromFormat($this->formatDate, $request->date));
        }
        if ($request->has('address') && !is_null($request->address)) {
            $events->where('address', 'LIKE', '%' . $request->address . '%');
        }

        if ($request->has('lawyer') && !is_null($request->lawyer)) {
            $events->whereHas('lawyer', function ($query) use ($request) {
                return $query->where('name', 'like', $request->lawyer);
            });
        }
        return $events;
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
            ->responsive(true)
            ->language('//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json')
            ->searching(true)
//            ->serverSide(true)
            ->buttons([
                Button::make('csv'),
                Button::make('print'),

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
            Column::make('name', 'name')->title('Nome'),
            Column::make('start_time')->title('Hora de início'),
            Column::make('end_time')->title('Hora de Fim'),
            Column::make('recurrence')->title('Recorrência'),
            Column::make('address')->title('Endereço'),
            Column::make('lawyer', 'lawyer.name')->title('Advogado'),
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
