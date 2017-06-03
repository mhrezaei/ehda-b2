<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="row">

            {{ null, $selectOptions = [] }}
            @foreach($posts as $post)
                {{ null, $post->spreadMeta() }}

                {{-- generating array for options of select element that will be used for selecting file type--}}
                {{ null, $selectOptions[] = ['id' => $post->id, 'title' => trans("front.file_types.$post->fileType.title")] }}

                @if($post->fields)
                    {{ null, $fields[$post->id] = explodeNotEmpty(',' , $post->fields) }}
                    @foreach($fields[$post->id] as $fieldIndex => $fieldValue)
                        @unset($fields[$post->id][$fieldIndex])
                        {{ null, $fieldValue = trim($fieldValue) }}

                        @if(str_contains($fieldValue, '*'))
                            {{ null, $fieldValue = str_replace('*', '', $fieldValue) }}
                            {{ null, $tmpField['required'] = true }}
                        @else
                            {{ null, $tmpField['required'] = false }}
                        @endif

                        @if(str_contains($fieldValue, '-label'))
                            {{ null, $fieldValue = str_replace('-label', '', $fieldValue) }}
                            {{ null, $tmpField['label'] = true }}
                        @else
                            {{ null, $tmpField['label'] = false }}
                        @endif

                        @if(str_contains($fieldValue, ':'))
                            {{ null, $fieldValueParts = explodeNotEmpty(':', $fieldValue) }}
                            {{ null, $fieldValue = $fieldValueParts[0] }}
                            {{ null, $tmpField['size'] = $fieldValueParts[1] }}
                        @else
                            {{ null, $tmpField['size'] = '' }}
                        @endif
                        {{ null, $fields[$post->id][$fieldValue] = $tmpField }}
                    @endforeach
                @endif
            @endforeach

            {{-- generate an indexed array of file types --}}
            {{ null, $fileTypes = $posts->pluck('fileType')->toArray() }}

            @include('front.forms.select', [
                'id' => 'file-type',
                'name' => 'file_type',
                'options' => $selectOptions
            ])

        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        @section('head')
            @parent
            {!! Html::style('assets/css/dropzone.min.css') !!}
        @endsection
        @section('endOfBody')
            @parent
            {!! Html::script('assets/libs/dropzone/dropzone.min.js') !!}
            {!! Html::script('assets/libs/jquery.form.min.js') !!}
            {!! Html::script('assets/js/forms.min.js') !!}
            <script>
                // if we miss this command, every elements with "dropzone" class will be automatically change to dropzone
                Dropzone.autoDiscover = false;

                // setting default options for all dropzone uploaders in this page
                Dropzone.prototype.defaultOptions.url = "{{ $uploadUrl }}";
                Dropzone.prototype.defaultOptions.addRemoveLinks = true;
                Dropzone.prototype.defaultOptions.dictRemoveFile = "";
                Dropzone.prototype.defaultOptions.dictCancelUpload = "";
                Dropzone.prototype.defaultOptions.dictFileTooBig = "{{ trans('front.upload.errors.size') }}";
                Dropzone.prototype.defaultOptions.dictInvalidFileType = "{{ trans('front.upload.errors.type') }}";
                Dropzone.prototype.defaultOptions.dictResponseError = "{{ trans('front.upload.errors.server') }}";
                Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "{{ trans('front.upload.errors.limit') }}";


                // convert $fields array to json to be used in js code
                var fields = {!! json_encode($fields) !!};

                /**
                 * kick the element out from the page
                 * hide it and disable it to not be submitted
                 */
                $.fn.kickOut = function () {
                    $(this).hide();
                    if ($(this).is(':input')) {
                        $(this).attr('disabled', 'disabled');
                    } else {
                        $(this).find(':input').each(function () {
                            $(this).attr('disabled', 'disabled');
                        });
                    }
                };

                /**
                 * turn the element over to the page
                 */
                $.fn.turnOver = function (required) {
                    if ($(this).is(':input')) {
                        if (isDefined(required) && required) {
                            $(this).addClass('form-required');
                        }
                        $(this).removeAttr('disabled');
                    } else {
                        $(this).find(':input').each(function () {
                            if (isDefined(required) && required) {
                                $(this).addClass('form-required');
                            }
                            $(this).removeAttr('disabled');
                        });
                    }

                    $(this).show();
                };

                $(document).ready(function () {

                    $('#file-type').change(function () {
                        var id = $(this).val();
                        var postFields = fields[id];
                        $('#post-id').val(id);

                        $('.optional-input').each(function () {
                            var elem = $(this);
                            var fieldName = elem.attr('data-field');
                            if ($.inArray(fieldName, Object.keys(postFields)) > -1) {
                                elem.turnOver(postFields[fieldName]['required']);
                            } else {
                                elem.kickOut();
                            }
                        })
                    }).change();
                });
            </script>
        @endsection

        {{-- generate uploaders panel for all files types --}}
        @foreach($fileTypes as $fileType)
            {{ null, $dataField = "{$fileType}_uploader" }}
            {!! UploadServiceProvider::showUploader($fileType, [
                'id' => "$fileType-uploader",
                'dataAttributes' => [
                    'field' => $dataField,
                ],
            ]) !!}


        @section('hiddenFields')
            @include('front.forms.hidden',[
                'name' => "file_$fileType",
                'extra' => "data-field=$dataField",
                'class' => 'optional-input',
            ])
        @append

        @endforeach


        {!! Form::open([
            'url' => route('comment.submit'),
            'method'=> 'post',
            'class' => 'js',
            'name' => 'commentForm',
            'id' => 'commentForm',
        ]) !!}
        @include('front.forms.hidden',[
            'name' => 'post_id',
            'value' => '',
            'id' => 'post-id',
        ])

        @yield('hiddenFields')
        <div class="row">


            <div class="col-md-6 col-xs-12 optional-input" data-field="subject">
                <div class="row">
                    @include('front.forms.input', [
                        'name' => 'subject',
                        'placeholder' => trans('validation.attributes.title'),
                        'label' => trans('validation.attributes.submission_work_subject'),
                    ])
                </div>
            </div>

            <div class="col-md-6 col-xs-12 optional-input" data-field="name">
                <div class="row">
                    @include('front.forms.input', [
                        'name' => 'name',
                        'placeholder' => trans('validation.attributes.first_and_last_name'),
                        'label' => trans('validation.attributes.submission_work_owner_name'),
                    ])
                </div>
            </div>

            <div class="col-md-6 col-xs-12 optional-input" data-field="mobile">
                <div class="row">
                    @include('front.forms.input', [
                        'name' => 'mobile',
                        'placeholder' => trans('validation.attributes.mobile'),
                        'label' => trans('validation.attributes.submission_work_owner_mobile'),
                    ])
                </div>
            </div>

            <div class="col-md-6 col-xs-12 optional-input" data-field="email">
                <div class="row">
                    @include('front.forms.input', [
                        'name' => 'email',
                        'placeholder' => trans('validation.attributes.email'),
                        'label' => trans('validation.attributes.submission_work_owner_email'),
                    ])
                </div>
            </div>

            <div class="col-xs-12 optional-input" data-field="description">
                <div class="row">
                    @include('front.forms.textarea', [
                        'name' => 'description',
                        'rows' => 4,
                        'placeholder' => trans('validation.attributes.description'),
                        'label' => trans('validation.attributes.description'),
                    ])
                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group pt15">
                    <div class="action tal">
                        <button class="btn btn-primary pull-left">{{ trans('front.send_work') }}</button>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 pt15">
                @include('front.forms.feed')
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
