@extends('errors::minimal')

@section('title', __('error.Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'error.Forbidden'))
