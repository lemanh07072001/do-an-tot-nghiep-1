@extends('client.layout.layoutMatter')

@section('content')
    <!-- Break -->
    <section>
        <div class="container max-w-[1170px] mx-auto items-center h-full px-2.5 pt-6 ">
            {!! $getData->content ?? '' !!}
        </div>
    </section>
    <!-- End -->


@endsection


