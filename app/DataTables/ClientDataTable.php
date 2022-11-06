<?php

namespace App\DataTables;

use App\Models\Clients;
use App\Traits\CompanySessionTraits;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends DataTable
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
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return $this->dataAction('admin.clients', $data->pid);
            })
            ->addColumn('fullname', function ($data) {
                return $data->fullname;
            })
            ->addColumn('benefit', function ($data) {
                return (!!$data->benefit) ? __($data->benefit->name) : null;
            })
            ->addColumn('status', function ($data) {
                return (!!$data->status) ? __('view.' . $data->status->status) : null;
            })
            ->addColumn('lastupdate', function ($data) {
                return (!!$data->status) ? date_format($data->status->created_at, 'd/m/Y h:i') : null;
            })
            ->addColumn('birth_date', function ($data) {
                return (isset($data->birth_date)) ? Carbon::make($data->birth_date)->format('d/m/Y') : null;
            })
            ->filterColumn('fullname', function ($query, $keyword) {
                $sql = "CONCAT(name,' ',last_name)  like ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                return $query->where('status.status', 'LIKE', ["%{$keyword}%"]);
            })
            ->filterColumn('benefit', function ($query, $keyword) {
                return $query->where('benefit.name', 'LIKE', ["%{$keyword}%"]);
            })
            ->rawColumns(['action'])
            ->smart(true) // Pesquisa inteligente em tempo de execução
//            ->addColumn('action', 'clientdatatable.action')
            ->setRowId('id');
    }

    private function dataAction($route, $id, $action = ['view', 'edit'])
    {

        $v = '<div class="table-data-feature">';
        $e = '</div>';
        if (in_array('view', $action)) {
            $v .= '<a href="' .
                route($route . '.show', ['client' => $id])
                . '" class="item" data-toggle="tooltip" data-placement="top" data-original-title="Ver"><i class="fa fa-eye"></i></a> ';
        }

        if (in_array('edit', $action) && $this->hasPermission('edit_client')) {
            $e = '<a href="'
                . route($route . '.edit', ['client' => $id])
                . '" class="item" data-toggle="tooltip" data-placement="top" data-original-title="Editar"><i class="fa fa-edit"></i></a></div>';
        }

        return $v . $e;

    }


    /**
     * Get query source of dataTable.
     *
     * @param Clients $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): QueryBuilder
    {
        $request = $this->request();
        $clients = Clients::where('company_id', $this->getCompanyId())->with(['status', 'benefit']);

        if ($request->has('name') && !is_null($request->name)) {
            $clients->whereRaw("CONCAT(name,' ',last_name)  like ?", ["%{$request->name}%"]);
        }

        if ($request->has('month') && !is_null($request->month)) {
             $clients->whereMonth('created_at', $request->month);
        }
        if ($request->has('sex') && !is_null($request->sex)) {
            $clients->whereSex($request->sex);
        }
        if ($request->has('city') && !is_null($request->city)) {
            $clients->whereCity($request->city);
        }
        if ($request->has('state') && !is_null($request->state)) {
            $clients->whereState($request->state);
        }
        if ($request->has('district') && !is_null($request->district)) {
             $clients->whereDistrict($request->district);
        }
        if ($request->has('status') && !is_null($request->status)) {
             $clients->whereHas('status', function ($query) use ($request) {
                $query->where('status', 'like', $request->status);
            });
        }
        if ($request->has('recommendation') && !is_null($request->recommendation)) {
          $clients->whereHas('recommendation', function ($query) use ($request) {
                $query->where('name', 'like', $request->recommendation);
            });
        }
        if ($this->hasRole('admin') && $this->hasPermission('edit_client')) {
            // Caso o Admin também deseje ter acesso a os clientes.
            $clients = Clients::newQuery();
        }

        return $clients;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('clientdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->responsive(true)
//            ->serverSide(true)
            ->language('//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json')
            ->searching(true)
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

            Column::make('fullname', 'fullname')->title('Nome'),
            Column::make('sex', 'sex')->title('Sexo'),
            Column::make('email', 'email')->title('Email'),
            Column::make('tel0', 'tel0')->title('Telefone'),
            Column::make('birth_date', 'birth_date')->title('Data de Nascimento'),
            Column::make('cpf', 'cpf')->title('CPF'),
            Column::make('benefit', 'benefit.name')->title('Beneficio'),
            Column::make('status', 'status.status')->title('Status'),
            Column::make('lastupdate', 'status.created_at')->title('Ultima Modificação')->searchable(false),
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
        return 'Client_' . date('YmdHis');
    }
}
