@extends('layouts.default')
@section('page-header') Funcionário @endsection
@section('content')

                            <span class="middle">{{$employee->fullname}}</span>
                        </h4>


                        <div class="profile-user-info">


                            <div class="profile-info-row">
                                <div class="profile-info-name">Endereço</div>

                                <div class="profile-info-value">
                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                    <span>{{$employee->address}} {{$employee->number}} {{$employee->complement}}</span>
                                    <span>{{$employee->district}} {{$employee->city}} {{$employee->state}}</span>
                                    <span>{{$employee->cep}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Sexo</div>

                                <div class="profile-info-value">
                                    <span>{{__('view.sex.'.$employee->sex)}}</span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Data de Nascimento</div>



@endsection
