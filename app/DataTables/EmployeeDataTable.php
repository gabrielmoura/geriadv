<?php

namespace App\DataTables;

use App\Models\Employee;
use App\Traits\CompanySessionTraits;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
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
            ->addColumn('status', fn($employee) => $this->status($employee))
            ->addColumn('action', fn($employee) => $this->action($employee))
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * @param Employee $employee
     * @return string
     */
    private function status(Employee $employee)
    {
        return ($employee->banned) ? '<span class="badge badge-success">Ativo</span>' : '<span class="badge badge-secondary">Inativo</span>';
    }

    /**
     * @param Employee $employee
     * @return string
     */
    private function action(Employee $employee)
    {
        return '<div class="table-data-feature"><a href="' . route('admin.employee.show', ['employee' => $employee->pid]) . '"><i
                                class="fa fa-eye"></i></a>|<a
                            href="' . route('admin.employee.edit', ['employee' => $employee->pid]) . '"><i
                                class="fa fa-edit"></i></a></div>';

    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): QueryBuilder
    {
        return Employee::where('company_id', $this->getCompanyId());
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('employeedatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
//            ->dom('Bfrtip') // add l
            ->orderBy(1)
            ->selectStyleSingle()
            ->responsive(true)
//            ->serverSide(true)
            ->language('//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json')
            ->buttons([
                Button::make('export'),
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
            Column::make('name', 'name')->title('Name'),
            Column::make('sex', 'sex')->title('Sexo'),
            Column::make('email', 'email')->title('Email'),
            Column::make('tel0', 'tel0')->title('Telefone'),
            Column::make('address', 'address')->title('Endereços'),
            Column::make('birth_date', 'birth_date')->title('Data de Nascimento'),
            Column::make('cpf', 'cpf')->title('CPF')->searchable(false),
            Column::computed('status')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->title('Status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->title('Ação'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Employee_' . date('YmdHis');
    }
}
