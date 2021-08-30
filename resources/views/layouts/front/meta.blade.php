<meta name="author" content="{{config('metadata.author')}}"/>
<meta itemprop="name" content="{{config('metadata.name')}}"/>
<meta itemprop="email" content="{{config('metadata.email')}}"/>
<meta itemprop="telephone" content="{{config('metadata.telephone')}}"/>
<link itemprop="url" href="{{config('metadata.url')}}"/>
<meta name="theme-color" content="{{config('metadata.theme-color')}}"/>
<script type="application/ld+json">
   {!! collect(config('metadata.header'))->toJson() !!}
</script>


