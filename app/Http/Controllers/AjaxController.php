<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Adm\EmployeeController;
use App\Mail\Client\GenericMail;
use App\Models\Benefits;
use App\Models\Clients;
use App\Models\ClientStatus;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Note;
use App\Models\UserOrder;
use App\Traits\CompanySessionTraits;
use Cagartner\CorreiosConsulta\Facade as Correios;
use Canducci\ZipCode\Facades\ZipCode;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/**
 * Class AjaxController
 * @package App\Http\Controllers
 */
class AjaxController extends Controller
{
    use CompanySessionTraits;

    /**
     * Retorna Todas as Rotas
     * @return \Illuminate\Routing\RouteCollectionInterface
     */
    public function routes()
    {
        $this->middleware('role_or_permission:admin');
        return Route::getRoutes();
    }

    /**
     * @param Request $request
     * @return mixed|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getCep(Request $request)
    {
        $this->validate($request, ['cep' => 'min:8|max:9']);
        $cep = numberClear($request->cep); //Apenas números;
        if (strlen($cep) != 8) return abort(400); //Diferente de 8 retorna HTTP400;
        return Cache::remember('cep:' . $cep, now()->addMonths(1), function () use ($cep) {
            return ZipCode::find($cep)->getArray();
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFrete()
    {
        $dados = [
            'tipo' => 'sedex', // Separar opções por vírgula (,) caso queira consultar mais de um (1) serviço. > Opções: `sedex`, `sedex_a_cobrar`, `sedex_10`, `sedex_hoje`, `pac`, 'pac_contrato', 'sedex_contrato' , 'esedex'
            'formato' => 'caixa', // opções: `caixa`, `rolo`, `envelope`
            //'cep_destino'       => '89062086', // Obrigatório
            'cep_origem' => config('metadata.cep'), // Obrigatorio
            //'empresa'         => '', // Código da empresa junto aos correios, não obrigatório.
            //'senha'           => '', // Senha da empresa junto aos correios, não obrigatório.
            'peso' => '1', // Peso em kilos
            'comprimento' => '16', // Em centímetros
            'altura' => '11', // Em centímetros
            'largura' => '11', // Em centímetros
            'diametro' => '0', // Em centímetros, no caso de rolo
            // 'mao_propria'       => '1', // Náo obrigatórios
            // 'valor_declarado'   => '1', // Náo obrigatórios
            // 'aviso_recebimento' => '1', // Náo obrigatórios
        ];
        $dados = array_merge($dados, ['cep_destino' => request('cep_destino')]);
        $tracking = Correios::frete($dados);

        return response()->json($tracking);
    }


    /**
     * Deverá Buscar o ultimo status do cliente
     * @param $id
     * @return mixed
     */
    public function getStatus($id)
    {
        return Clients::find($id)->status()->last();
    }

    /**
     * @param $status
     * @return ClientStatus[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByStatus($status)
    {
        return ClientStatus::whereStatus($status)->get();
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function setStatus(Request $request)
    {
        //$request = ClientsRule::Status($request);
        if (ClientStatus::whereClientId($request->clientID)->whereStatus($request->status)->count() >= 2) return abort(406, 'Limite Exedido');

        $status = ClientStatus::create(['status' => $request->status, 'client_id' => $request->clientID]);
        if ($status) {
            return abort(201);
        }
        return abort(400);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getNote($id)
    {
        return Clients::find($id)->status()->last();
    }

    /**
     * @param Request $request
     * @throws \Throwable
     */
    public function setNote(Request $request)
    {
        //
        //return Clients::find($id)->status()->create(['status' => $status]);
        $note = DB::transaction(function () use ($request) {
            $note = Note::create(['client_id' => $request->id, 'body' => $request->body]);
            /*activity()->performedOn($note)
                ->causedBy(auth()->user())
                //    ->withProperties(['customProperty' => 'customValue'])
                ->log('Adicionou observação ao cliente ' . Clients::find($request->clientID)->fullname); */
            if (!$note) {
                throw new \Exception('Não foi possivel adicionar Observação ao cliente', 400);
            }
            return $note;

        });
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function setBenefit(Request $request)
    {
        $benefits = DB::transaction(function () use ($request) {
            $benefits = Benefits::create(['name' => $request->name, 'description' => $request->description, 'client_id' => $request->clientID]);
            if (!$benefits) {
                throw new \Exception('Não foi possivel associar beneficio ao cliente', 400);
            }
            return $benefits;
        });
        return $benefits;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function setRecommendation(Request $request)
    {
        $recommendation = DB::transaction(function () use ($request) {
            $client = Clients::find($request->clientID);
            $recommendation = $client->recommendation()->create(['name' => $request->name]);
            $client->recommendation_id = $recommendation->id;
            $ok = $client->save();;
            //Recommendation::create(['client_id' => $request->id, 'body' => $request->body]);
            if (!$ok) {
                throw new \Exception('Não foi possivel associar indicação ao cliente', 400);
            }
            return $recommendation;

        });
        return $recommendation;
    }

    /**
     * Envia Email para Cliente
     * @param Request $request
     * @return mixed
     */
    public function sendMail(Request $request)
    {
        try {
            $message = (new GenericMail($request->body, $request->title))
                ->onConnection('redis')
                ->onQueue('emailqueue');
            $client = Clients::find($request->clientID);
            $mail = Mail::to($client)
                ->queue($message);

            activity()->performedOn($client)
                ->causedBy(auth()->user())
                ->withProperties([$request->body, $request->title])
                ->log('Enviou um email ao cliente ' . $client->fullname);
        } catch (\Exception $e) {

        }
        return response('', 201);
    }


    /**
     * Retorna lista de todos os agendamentos
     * @return string
     */
    public function getCalendar()
    {
        $events = [];

        foreach ($this->sources as $source) {
            foreach ($source['model']::all() as $model) {
                //$crudFieldValue = $model->getOriginal($source['date_field']);
                $crudFieldValue = Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $model->getOriginal($source['date_field']))->format('Y-m-d H:i:s');
                //$crudFieldValue=Carbon::parse($model->getOriginal($source['date_field']))->toDateTimeString();

                if (!$crudFieldValue) {
                    continue;
                }

                $events[] = [
                    'title' => trim($source['prefix'] . " " . $model->{$source['field']}
                        . " " . $source['suffix']),
                    'start' => $crudFieldValue,
                    //'end' => $model->{$source['end_field']},
                    'end' => Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $model->{$source['end_field']})->format('Y-m-d H:i:s'),
                    'description' => $model->description ?? '',
                    'url' => route($source['route'], $model->id),
                ];
            }
        }
        return collect($events)->toJson();
    }

    /**
     * @return Benefits[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getBenefits()
    {
        return Benefits::where('company_id', Auth::user()->company()->id)->get();
    }

    /**
     * @return \App\Models\Calendar[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getAgendamento()
    {
        return \App\Models\Calendar::withCount('calendars')->whereMonth('created_at', '=', request('month'))->get();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function banCompany(Request $request)
    {
        $this->middleware('role:admin');

        $company = Company::findOrFail($request->company);
        $company->banned = true;

        if ($company->save()) {
            toastr()->success('Banido com sucesso.');
            cache()->forget('company:' . $request->company);
            return response()->json([], 200);
        }
        return response()->json([], 422);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function unBanCompany(Request $request)
    {
        $this->middleware('role:admin');

        $company = Company::findOrFail($request->company);
        $company->banned = false;
        if ($company->save()) {
            toastr()->success('Desbanido com sucesso.');
            cache()->forget('company:' . $request->company);
            return response()->json([], 200);
        }
        return response()->json([], 422);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|never
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function banEmployee(Request $request)
    {
        $this->middleware('role:manager');

        $employee = Employee::where('company_id', $this->getCompanyId())
            ->where('pid', $request->pid)
            ->firstOrFail();
        $employee->banned = true;

        if ($employee->save()) {
            toastr()->success('Ativado com sucesso.');
            cache()->forget('user:' . $employee->user()->first()->id);
            return response()->json('ok');
        }
        return abort(422);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|never
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function unBanEmployee(Request $request)
    {
        $this->middleware('role:manager');

        $employee = Employee::where('company_id', $this->getCompanyId())
            ->where('pid', $request->pid)
            ->firstOrFail();
        $employee->banned = false;
        if ($employee->save()) {
            toastr()->success('Desativado com sucesso.');
            cache()->forget('user:' . $employee->user()->first()->id);
            return response()->json('ok');
        }
        return abort(422);

    }
}
