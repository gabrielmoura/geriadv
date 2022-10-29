<?php

namespace App\DataTables;

use App\Models\Benefits;
use App\Traits\CompanySessionTraits;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BenefitDataTable extends DataTable
{
    use CompanySessionTraits;

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Benefits $benefits) {
                return '<a href="' . route('admin.benefit.edit', ['benefit' => $benefits->pid]) . '"><i
                                class="fa fa-edit"></i></a></div>';
            })
            ->addColumn('amount', function (Benefits $benefits) {
                return calculateAmount($benefits);
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Benefits $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Benefits $model): QueryBuilder
    {
        return $model->newQuery()->where('company_id', $this->getCompanyId());
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('benefitdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->serverSide(true)
            ->selectStyleSingle()
            ->responsive(true)
            ->language('//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json')
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
            Column::make('description', 'description')->title('Descrição'),
            Column::make('wage_type', 'wage_type')->title('Tipo de Remuneração'),

            Column::computed('amount')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->hidden()
                ->addClass('text-center')
                ->title('Ação'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title('Ação'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Benefit_' . date('YmdHis');
    }
}
