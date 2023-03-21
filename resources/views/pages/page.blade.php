<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{!! $page->title !!}</title>
    <style>
        {{--{!! $page->custom_css !!}--}}
        {!! $page->custom_css !!}
    </style>
</head>
<body>
{!! $page->content !!}
<script>
    {!! $page->custom_js !!}
</script>
</body>
</html>
