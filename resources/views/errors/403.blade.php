@extends('errors::minimal')

@section('title', __('Prohibida'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Prohibida'))
