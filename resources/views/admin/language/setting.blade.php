@extends('admin.layout.master')

@section('content')

    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">

                    <h4>

                        <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                            @changeLang('Add Key And Value')</button>
                    </h4>

                    @if ($exports->count() > 0)


                        <div class="card-header-form">
                           
                                <div class="form-group">
                                    <label for="">@changeLang('Export Language')</label>
                                    <select name="" id="" class="form-control Langchange">
                                        <option data-url="{{ route('admin.language.key', request()->language) }}" value="">@changeLang('Select Export Language')</option>
                                        @foreach ($exports as $export)
                                            <option data-url="{{ route('admin.export',[request()->language,$export->shortcode]) }}"
                                                value="{{ $export->name }}">{{ __($export->name) }}</option>
                                        @endforeach

                                    </select>

                                </div>
                           
                        </div>
                    @endif
                </div>
                <div class="card-body">

                    <form action="" method="post">
                        @csrf
                        <div class="row ">

                            @forelse($fileData as $key => $value)


                                <div class="form-group col-md-5">
                                    <label for="">@changeLang('Language Key')</label>
                                    <input type="text" name="key[]" class="form-control" value="{{ $key }}">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="">@changeLang('Translate Value')</label>
                                    <input type="text" name="value[]" class="form-control" value="{{ $value }}">
                                </div>
                                @if (!$loop->first)

                                    <div class="form-group col-md-2 ">
                                        <label for=""></label>
                                        <button class="btn btn-danger w-100 delete-v"><i class="fa fa-times"></i></button>
                                    </div>
                                @endif
                            @empty

                                <div class="form-group col-md-5">
                                    <label for="">@changeLang('Language Key')</label>
                                    <input type="text" name="key[]" class="form-control">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="">@changeLang('Translate Value')</label>
                                    <input type="text" name="value[]" class="form-control">
                                </div>
                                <div class="form-group col-md-2 ">
                                    <label for=""></label>
                                    <button class="btn btn-danger w-100 delete-v"><i class="fa fa-times"></i></button>
                                </div>

                            @endforelse

                            <div class="col-md-12">

                                <div class="row deleteData">


                                </div>

                                <button type="submit" class="btn btn-primary w-100">@changeLang('Update Language')</button>

                            </div>



                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')

    <script>
        $(function() {
            'use strict'
            $('.add').on('click', function() {
                var html = `
                    <div class="form-group col-md-5">
                                <label for="">@changeLang('Language Key')</label>
                                <input type="text" name="key[]" class="form-control">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="">@changeLang('Translate Value')</label>
                                <input type="text" name="value[]" class="form-control">
                            </div>
                            <div class="form-group col-md-2 ">
                                <label for=""></label>
                                <button class="btn btn-danger w-100 delete-v"><i class="fa fa-times"></i></button>
                            </div>
                           
                
                
                `;

                $('.deleteData').append(html);
            })

            $(document).on('click', '.delete', function() {
                $(this).closest('.deleteData').remove();
            });

         
        })
    </script>

@endpush
