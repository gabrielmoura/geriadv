<?php

namespace App\DataTables;

use App\Traits\CompanySessionTraits;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use App\Models\Lawyer;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LawyerDataTable extends DataTable
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
            ->addColumn('action', function ($lawyer) {
                return '<div class="table-data-feature"><a href="' . route('admin.lawyer.show', ['lawyer' => $lawyer->pid]) . '" class="m-2"><i
                                class="fa fa-eye"></i></a><a
                            href="' . route('admin.lawyer.edit', ['lawyer' => $lawyer->pid]) . '" class="m-2"><i
                                class="fa fa-edit"></i></a></div>';
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     * @param Lawyer $model
     * @return QueryBuilder
     */
    public function query(Lawyer $model): QueryBuilder
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
            ->setTableId('lawyerdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('csv'),
                Button::make('print'),

            )
//            ->serverSide(true)
            ->language('//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json')
            ->responsive(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [

            Column::make('name', 'name')->title('Nome'),
            Column::make('last_name', 'last_name')->title('Sobrenome'),
            Column::make('email', 'email')->title('Email'),
            Column::make('cpf', 'cpf')->title('CPF'),
            Column::make('oab', 'oab')->title('OAB'),
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
        return 'Lawyer_' . date('YmdHis');
    }
}
