<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SWTimmy</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link href="/packages/fontawesome/css/all.css" rel="stylesheet">

    <link href="/packages/native-toast/native-toast.css" rel="stylesheet">

    <link href="/css/app.css" rel="stylesheet">

    <link href="/css/font-awesome.css" rel="stylesheet">

    <style>
    @section("css")
    @show
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, user-scalable=no" />
</head>