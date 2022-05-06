@extends('layouts.front')
@section('title',__('Bem Vindo'))
@section('content')
    <section class="clean-block clean-hero" id="start"
             style="background-image:url(&quot;images/tech/image4.jpg&quot;);color:rgba(9, 162, 255, 0.85);"><a
            class="d-md-flex justify-content-md-center align-items-md-center pulse animated infinite" id="wp"
            target="_blank"
            style="background: url(&quot;images/botao-whatsapp.png&quot;) center / contain no-repeat, #5bbf21;width: 154px;height: 44px;"
            href="https://api.whatsapp.com/send/?phone={{config('meta.whatsapp.number')}}&amp;text={{config('meta.whatsapp.text')}}&app_absent=0"></a>
        <div class="text">
            <h2>GeriADV.</h2>
            <p>Gerente Virtual para seu escritório.</p>

        </div>
    </section>
    <section class="clean-block clean-info dark" id="info">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Informação</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in,
                    mattis vitae leo.</p>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6"><img class="img-thumbnail" src="images/scenery/image5.jpg"></div>
                <div class="col-md-6">
                    <h3>Lorem impsum dolor sit amet</h3>
                    <div class="getting-started-info">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet,
                            consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    </div>
                    <button class="btn btn-outline-primary btn-lg" type="button">Join Now</button>
                </div>
            </div>
        </div>
    </section>
    <section class="clean-block features" id="features">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Features</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in,
                    mattis vitae leo.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5 feature-box"><i class="icon-star icon"></i>
                    <h4>Bootstrap 4</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in,
                        mattis vitae leo.</p>
                </div>
                <div class="col-md-5 feature-box"><i class="icon-pencil icon"></i>
                    <h4>Customizable</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in,
                        mattis vitae leo.</p>
                </div>
                <div class="col-md-5 feature-box"><i class="icon-screen-smartphone icon"></i>
                    <h4>Responsive</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in,
                        mattis vitae leo.</p>
                </div>
                <div class="col-md-5 feature-box"><i class="icon-refresh icon"></i>
                    <h4>All Browser Compatibility</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in,
                        mattis vitae leo.</p>
                </div>
            </div>
        </div>
    </section>

    {{--<section>--}}
    {{--            <div class="container">--}}
    {{--                <div class="section-heading">--}}
    {{--                    <h3>Perguntas mais frequentes</h3>--}}
    {{--                    <p class="width-55 sm-width-75 xs-width-95">Leia as dúvidas mais frequentes com relação ao Assessor.com</p>--}}
    {{--                </div>--}}
    {{--                <div class="row">--}}

    {{--                    <div class="col-lg-12 col-md-12">--}}

    {{--                        <div id="accordion" class="accordion-style3">--}}
    {{--                                <div class="card">--}}
    {{--                                    <div class="card-header" id="headingOne">--}}
    {{--                                      <h5 class="mb-0">--}}
    {{--                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">--}}
    {{--                                        Quais as principais diferenças entre os planos?--}}
    {{--                                        </button>--}}
    {{--                                      </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">--}}
    {{--                                      <div class="card-body bg-white">--}}
    {{--                                        Basicamente o tempo de acesso, quanto maior for o período, menor o valor referente a cada mês. Qualquer plano pode ser pago de maneira parcelada em até o limite de tempo do plano escolhido. (Semestral em 6x e Anual em 12x)--}}
    {{--                                      </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="card">--}}
    {{--                                    <div class="card-header" id="headingTwo">--}}
    {{--                                        <h5 class="mb-0">--}}
    {{--                                          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">--}}
    {{--                                            Quais as diferenças entre “O assessor” e outros softwares de gerenciamento político.--}}
    {{--                                          </button>--}}
    {{--                                        </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion" style="">--}}
    {{--                                        <div class="card-body bg-white">--}}
    {{--                                          Uma grande diferença é que por ser um sistema totalmente online, nosso usuário tem mais segurança e flexibilidade. Mesmo que o computador seja perdido ou formatado os dados dos nossos clientes estarão protegidos na “nuvem”, também por ser online nosso sistema é acessível de qualquer dispositivo com internet, o que garante mais flexibilidade para o usuário.--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="card">--}}
    {{--                                    <div class="card-header" id="headingThree">--}}
    {{--                                        <h5 class="mb-0">--}}
    {{--                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">--}}
    {{--                                 Meus dados cadastrados no sistema estarão seguros?--}}

    {{--                                </button>--}}
    {{--                              </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">--}}
    {{--                                        <div class="card-body bg-white no-padding-bottom">--}}
    {{--                                            Sim, totalmente. Sabemos a importância das informações de nossos usuários, e por isso garantimos que somente ele, ou quem ele der permissão através de subcontas e permissões, terá acesso a tais informações. Nossos servidores fazem backups diários e os dados ficam criptografados, garantindo assim total sigilo e segurança aos nossos clientes. <br><br>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}

    {{--                                 <div class="card">--}}
    {{--                                    <div class="card-header" id="headingThree">--}}
    {{--                                        <h5 class="mb-0">--}}
    {{--                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapseThree">--}}
    {{--                                Após encerrado meu plano, posso ter acesso aos dados que cadastrei?--}}

    {{--                                </button>--}}
    {{--                              </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapse4" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">--}}
    {{--                                        <div class="card-body bg-white no-padding-bottom">--}}
    {{--                                           Sem dúvida. O cliente poderá exportar em uma planilha todo seu banco de dados, porém caso não renove seu plano, não poderá mais desfrutar das funcionalidades, comodidades e segurança do nosso sistema. <br><br>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}



    {{--                                  <div class="card">--}}
    {{--                                    <div class="card-header" id="headingThree">--}}
    {{--                                        <h5 class="mb-0">--}}
    {{--                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapseThree">--}}
    {{--                               Existe alguma taxa inicial antes de começar a usar “O assessor “?--}}



    {{--                                </button>--}}
    {{--                              </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapse5" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">--}}
    {{--                                        <div class="card-body bg-white no-padding-bottom">--}}
    {{--                                        Não. Somos uma plataforma online que não requer nenhuma licença de software, instalação ou download em seu computador. Não existe taxa de setup, o cliente paga apenas pelo tempo que tiver acesso ao sistema.<br><br>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}




    {{--                                  <div class="card">--}}
    {{--                                    <div class="card-header" id="headingThree">--}}
    {{--                                        <h5 class="mb-0">--}}
    {{--                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapseThree">--}}
    {{--                               Com qual frequência devo pagar os planos do Oassessor.com?--}}


    {{--                                </button>--}}
    {{--                              </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapse6" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">--}}
    {{--                                        <div class="card-body bg-white no-padding-bottom">--}}
    {{--                                         O modelo de pagamento é sempre pré-pago. São três opções: mensal, semestral e anual. <br><br>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}


    {{--                                 <div class="card">--}}
    {{--                                    <div class="card-header" id="headingThree">--}}
    {{--                                        <h5 class="mb-0">--}}
    {{--                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">--}}
    {{--                               Além do pagamento de assinatura, existem outros pagamentos?--}}




    {{--                                </button>--}}
    {{--                              </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapse7" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">--}}
    {{--                                        <div class="card-body bg-white no-padding-bottom">--}}
    {{--                                        Sim, mas são opcionais. Cobramos para envio de sms, o cliente compra créditos pré pagos, para realizar o envio de sms para sua base eleitoral. Esses créditos não expiram e podem ser usados a qualquer momento pelos clientes, os valores são bem abaixo do mercado, apenas para cobrir os custos e garantir uma entrega eficiente e um serviço de qualidade.<br><br>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}



    {{--                                 <div class="card">--}}
    {{--                                    <div class="card-header" id="headingThree">--}}
    {{--                                        <h5 class="mb-0">--}}
    {{--                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapseThree">--}}
    {{--                              Como eu faço para cancelar minha assinatura?--}}




    {{--                                </button>--}}
    {{--                              </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapse8" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">--}}
    {{--                                        <div class="card-body bg-white no-padding-bottom">--}}
    {{--                                        Qualquer assinatura poderá ser cancelada a qualquer momento diretamente pelo site ou através do nosso e-mail: contato@oassessor.com.br<br><br>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}



    {{--                                 <div class="card">--}}
    {{--                                    <div class="card-header" id="headingThree">--}}
    {{--                                        <h5 class="mb-0">--}}
    {{--                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapseThree">--}}
    {{--                               Como funciona o Teste Gratuito?--}}



    {{--                                </button>--}}
    {{--                              </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapse9" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">--}}
    {{--                                        <div class="card-body bg-white no-padding-bottom">--}}
    {{--                                        Oferecemos para todos os planos um período de testes de 7 dias gratuitos, para que o cliente possa conhecer nosso sistema e avaliar nosso serviço. O cancelamento poderá ser realizado a qualquer momento.<br><br>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}



    {{--                                 <div class="card">--}}
    {{--                                    <div class="card-header" id="headingThree">--}}
    {{--                                        <h5 class="mb-0">--}}
    {{--                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapseThree">Como funciona o pagamento?--}}

    {{--                                </button>--}}
    {{--                              </h5>--}}
    {{--                                    </div>--}}
    {{--                                    <div id="collapse10" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">--}}
    {{--                                        <div class="card-body bg-white no-padding-bottom">--}}
    {{--                                         Após o período gratuito de teste, caso não seja realizado o cancelamento, os pagamentos serão debitados no cartão de crédito indicado, de acordo com plano escolhido pelo cliente. <br><br>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                        </div>--}}

    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </section>--}}

@endsection

