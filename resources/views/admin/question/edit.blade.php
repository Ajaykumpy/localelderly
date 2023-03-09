@extends('admin.layouts.default')
@section('title', 'Edit Question')
@section('content')
    @push('head')
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
            integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .switchery {
                height: 14px;
                width: 35px;
            }
            .switchery>small {
                height: 15px;
                width: 15px
            }
        </style>
    @endpush
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-tag bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Question') }}</h5>
                            <span>{{ __('List of Question') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.question.index') }}"><i class="ik ik-home"></i></a>
                            </li>                            
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('admin.includes.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-header px-1">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>{{ __('Edit Question') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="question-form" method="post" action="{{ route('admin.question.update', $question->id) }}">
                            @csrf
                            @method('put')
                            <div class="form-row">

                                <div class="col-md-6">
                                    <label>Parent Question</label>
                                    {{-- <select name="parent_id" class="form-control select2-question">
                                    <option value="">-- Select Question --</option>
                                </select> --}}
                                    <input type="hidden" name="parent_id" value="{{ $question->parent_id }}">
                                    <input type="text" name="parent" class="form-control"
                                        value="{{ $question->parent->question ?? '' }}" placeholder="Qeustion parent">
                                    <div class="parent_option">
                                        <div class="btn-group btn-group-toggle mt-2 mb-2" data-toggle="buttons">
                                            @if ($question->parent && $question->parent->options)
                                                @forelse($question->parent->options as $items)
                                                    <label class="btn btn-outline-primary btn-toggle">
                                                        <input type="radio" name="parent_option_id"
                                                            id="option{!! $items->question_option_id !!}"
                                                            data-score="{!! $items->score !!}"
                                                            value="{!! $items->question_option_id !!}" autocomplete="off"
                                                            {!! $items->question_option_id == $question->parent_option_id ? 'checked' : '' !!}> {!! $items->name !!}
                                                    </label>
                                                @empty
                                                @endforelse
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-4">
                                    <label>Type <span class="text-red">*</span></label>
                                    <input type="hidden" name="option_id" value="{{ $question->option_id }}">
                                    <select id="input-type" name="type" class="form-control">
                                        <option value="">Select Type</option>
                                        @forelse($type as $items)
                                            <option value="{{ $items->type }}" data-option_id="{{ $items->option_id }}"
                                                {{ $items->option_id == $question->option_id ? 'selected' : '' }}>
                                                {{ $items->description->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Status</label>
                                    <div><input type="checkbox" class="js-small" name="status" value="1"
                                            {{ $question->status == 1 ? 'checked' : '' }} /> </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Validate</label>
                                    <select class="form-control" name="validator">
                                        @forelse($validator as $items)
                                            <option value="{{ $items->slug }}"
                                                {{ $question->validator == $items->slug ? 'selected' : '' }}>
                                                {!! $items->title !!}</option>
                                        @empty
                                            <option value="required">Required</option>
                                        @endforelse
                                    </select>
                                </div>

                            </div>
                            <!-- Option -->
                            <div class="form-row">
                                <div class="col-md-12">
                                    <fieldset class="{{ empty($question->options) ? 'd-none' : '' }}">
                                        <legend>Option Values</legend>
                                        <table id="option-value" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td class="text-start required">Option Value Name <span
                                                            class="text-red">*</span></td>
                                                    <td class="text-center">Comment</td>
                                                    <td class="text-end d-none">Sort Order</td>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($question->options as $items)
                                                    <tr id="option-value-row-{{ $loop->index }}">
                                                        <td class="text-start"><input type="hidden"
                                                                name="option_value[{{ $loop->index }}][option_value_id]"
                                                                value="{{ $items->question_option_id }}">
                                                            <div class="input-groups">
                                                                <div class="input-group-text d-none"></div> <input
                                                                    type="text"
                                                                    name="option_value[{{ $loop->index }}][option_value_description][1][name]"
                                                                    value="{!! $items->name !!}"
                                                                    placeholder="Option Value Name"
                                                                    id="input-option-value-{{ $loop->index }}-1"
                                                                    class="form-control" required>
                                                            </div>
                                                            <div id="error-option-value-0-1" class="invalid-feedback">
                                                            </div>
                                                        </td>
                                                       
                                                       
                                                        <td class="text-end"><input type="text"
                                                                name="option_value[{{ $loop->index }}][comment]"
                                                                value="{{ $items->comment }}" placeholder="Comment"
                                                                class="form-control"></td>
                                                        
                                                        <td class="text-end"><button type="button"
                                                                onclick="$('#option-value-row-{{ $loop->index }}').remove();"
                                                                data-bs-toggle="tooltip" title="Remove"
                                                                class="btn btn-danger"><i
                                                                    class="fas fa-minus-circle"></i></button></td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td class="text-end"><button type="button"
                                                            onclick="addOptionValue();" data-bs-toggle="tooltip"
                                                            title="Add Option Value" class="btn btn-primary"><i
                                                                class="fas fa-plus-circle"></i></button></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>
                            <!-- ./end option -->
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="button" onclick="window.history.back();" class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @push('script')
    
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/jquery.validate.min.js"
            integrity="sha512-FOhq9HThdn7ltbK8abmGn60A/EMtEzIzv1rvuh+DqzJtSGq8BRdEN0U+j0iKEIffiw/yEtVuladk6rsG4X6Uqg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.4/additional-methods.min.js"
            integrity="sha512-XJiEiB5jruAcBaVcXyaXtApKjtNie4aCBZ5nnFDIEFrhGIAvitoqQD6xd9ayp5mLODaCeaXfqQMeVs1ZfhKjRQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"
            integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            Dropzone.autoDiscover = false;
        </script>
        <script>
            $(function() {
                
                var elem = document.querySelector('.js-small');
                var init = new Switchery(elem, {
                    color: '#4099ff',
                    jackColor: '#fff'
                });
                $('#input-type').on('change', function() {
                    if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox' || this
                        .value == 'image') {
                        $('#option-value').parent().removeClass('d-none');
                    } else {
                        $('#option-value').parent().addClass('d-none');
                    }
                    $('input[name="option_id"]').val($(this).find('option:selected').data('option_id'));
                });
                $('input[name="parent"]').autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: '{{ route('admin.question.index') }}',
                            dataType: "json",
                            data: {
                                query: request.term,
                                type: 'radio',
                                category_id: $('select[name="category_id"]').val()
                            },
                            success: function(data) {
                                response($.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        label: item.question,
                                        value: item.question,
                                        options: item.options
                                    };
                                }));
                            }
                        });
                    },
                    minLength: 0,
                    select: function(event, ui) {
                        $('input[name="parent_id"]').val(ui.item.id);
                        if (ui.item.options.length > 0) {
                            var html =
                                '<div class="btn-group btn-group-toggle mt-2 mb-2" data-toggle="buttons">';
                            $(ui.item.options).each(function(i, v) {
                                html += '<label class="btn btn-outline-primary btn-toggle">';
                                html += '<input type="radio" name="parent_option_id" id="option' + v
                                    .question_option_id + '" data-score="' + v.score + '" value="' +
                                    (v.question_option_id ?? 0) + '" autocomplete="off" checked> ' +
                                    v.name;
                                html += '</label>';
                            });
                            html += '</div>';
                            $('.parent_option').empty().append(html);
                        }
                    }
                }).on('focus', function(event) {
                    $(this).autocomplete("search", "");
                });
                $('input[name="parent"]').on('keyup', function(e) {
                    if (!this.value) {
                        $('input[name="parent_id"]').val('');
                        $('.parent_option').empty();
                    }
                });
                {{-- var newOption = new Option('{!! $question->parent->question??'' !!}', {!! $question->parent->id??0 !!},'{!! $question->parent->score??0 !!}','{!! $question->parent->options??'' !!}', false, false);
    $('.select2-question').append(newOption).trigger('change');
    $('.select2-question').select2({
        ajax: {
            url: '{{route('admin.question.index')}}',
            dataType: 'json',
            data:function(term){
                return {query: term,type:'radio', category_id:$('select[name="category_id"]').val()};
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.question,
                            id: item.id,
                            score:item.score,
                            options:item.options
                        }
                    })
                };
            }
        }
    });
    $('.select2-question').on('select2:select', function (e) {
        var data = e.params.data;
        if(data.options.length>0){
            var html='<div class="btn-group btn-group-toggle mt-2 mb-2" data-toggle="buttons">';
            $(data.options).each(function(i, v){
                html+='<label class="btn btn-outline-primary btn-toggle">';
                html+='<input type="radio" name="parent_option_id" id="option'+v.question_option_id+'" data-score="'+v.score+'" value="'+(v.question_option_id??0)+'" autocomplete="off" checked> '+v.name;
                html+='</label>';
            });
            html+='</div>';
            $('.parent_option').empty().append(html);
        }
    }); --}}
                $(document).on('change', 'input[type="radio"][name="parent_option_id"]', function(e) {
                    $('input[name="score"]').val($(this).data('score'));
                });
                //Validate
                $('#question-form').validate({
                    rules: {
                        'name': {
                            required: true
                        },
                        'category_id': {
                            required: true
                        },
                        'score': {
                            required: true
                        },
                        'type': {
                            required: true
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        element.siblings('.invalid-tooltip').remove();
                        error.addClass('invalid-tooltip');
                        element.closest('.form-group').addClass('position-relative');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
                $(document).on("keypress keyup blur", ".number", function(event) {
                    $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
                    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event
                            .which > 57)) {
                        event.preventDefault();
                    }
                });

            });
            var option_value_row = {{ $question->options->count() }} || 0;

            function addOptionValue() {
                html = '<tr id="option-value-row-' + option_value_row + '">';
                html += '  <td class="text-start"><input type="hidden" name="option_value[' + option_value_row +
                    '][option_value_id]" value="" />';
                html += '    <div class="input-groups">';
                html += '      <div class="input-group-text d-none"></div>';
                html += '      <input type="text" name="option_value[' + option_value_row +'][option_value_description][1][name]" value="" placeholder="Option Value Name" id="input-option-value-' +
                    option_value_row + '-1" class="form-control" required/>';
                html += '    </div>';
                html += '    <div id="error-option-value-' + option_value_row + '-1" class="invalid-feedback"></div>';
                html += '  </td>';
                html += '  <td class="text-center d-none">';
                
                html += '      <div class="card-body">';
                html += '        <button type="button" data-oc-toggle="image" data-oc-target="#input-image-' +
                    option_value_row + '" data-oc-thumb="#thumb-image-' + option_value_row +
                    '" class="btn btn-primary btn-sm btn-block"><i class="fas fa-pencil-alt"></i> Edit</button>';
                html += '        <button type="button" data-oc-toggle="clear" data-oc-target="#input-image-' +
                    option_value_row + '" data-oc-thumb="#thumb-image-' + option_value_row +
                    '" class="btn btn-warning btn-sm btn-block"><i class="fas fa-trash-alt"></i> Clear</button>';
                html += '      </div>';
                html += '    </div>';
                html += '  </td>';
                html += '  <td class="text-end"><input type="text" name="option_value[' + option_value_row +
                html += '  <td class="text-end"><input type="text" name="option_value[' + option_value_row +
                    '][comment]" value="" placeholder="Comment" class="form-control"/></td>';
                html += '  <td class="text-end d-none"><input type="text" name="option_value[' + option_value_row +
                html += '  <td class="text-end"><button type="button" onclick="$(\'#option-value-row-' + option_value_row +
                    '\').remove();" data-bs-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html += '</tr>';

                $('#option-value tbody').append(html);

                option_value_row++;

            }
        </script>
    @endpush
@stop
