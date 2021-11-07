@extends('layouts.front')
@section('content')
    <section class="clean-block clean-hero"
             style="background-image:url(&quot;images/tech/image4.jpg&quot;);color:rgba(9, 162, 255, 0.85);"><a
            class="d-md-flex justify-content-md-center align-items-md-center pulse animated infinite" id="wp"
            target="_blank"
            style="background: url(&quot;images/botao-whatsapp.png&quot;) center / contain no-repeat, #5bbf21;width: 154px;height: 44px;"
            href="https://api.whatsapp.com/send/?phone=552140028922&amp;text=Olá vim pelo GERIADV E gostaria de conhecer os planos!&app_absent=0"></a>
        <div class="text">
            <h2>GeriADV.</h2>
            <p>Gerente Virtual para seu escritório.</p>
            <button class="btn btn-outline-light btn-lg" type="button">Learn More</button>
        </div>
    </section>
    <section class="clean-block clean-info dark">
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
    <section class="clean-block features">
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
@endsection
