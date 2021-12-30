@extends('errors::minimal')

@section('title', __('error.TooManyRequests'))
@section('code', '429')
@section('message', __('error.TooManyRequests'))
