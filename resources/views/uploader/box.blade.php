{{-- start -- uploader form --}}
{{ null, $formData = [
        'method'=> 'post',
        'class' => "dropzone mb15 optional-input text-blue",
    ] }}

@if(isset($id) and $id)
    {{ null, $formData['id'] = $id }}
@endif

@if(isset($dataAttributes) and is_array($dataAttributes) and count($dataAttributes))
    @foreach($dataAttributes as $fieldTitle => $filedValue)
        {{ null, $formData["data-$fieldTitle"] = $filedValue }}
    @endforeach
@endif

{!! Form::open($formData) !!}
<div class="dz-message" data-dz-message>
    <i class="fa fa-cloud-upload f70 text-white"></i>
    <br/>
    @if($boxIconName = UploadServiceProvider::getTypeRule($fileType, 'icon'))
        <i class="fa fa-{{ $boxIconName }}"></i> &nbsp;
    @endif
    <span>{{ trans("front.file_types.$fileType.dropzone_text") }}</span>
</div>
{!! Form::close() !!}
{{-- end -- uploader form --}}

{{-- start -- scripts for uploader --}}
@section('endOfBody')
    <script>
        $(document).ready(function () {
            $('#{{ $fileType }}-uploader').dropzone({
                maxFileSize: {{ UploadServiceProvider::getTypeRule($fileType, "maxFileSize") }},
                maxFiles: {{ UploadServiceProvider::getTypeRule($fileType, "maxFiles") }},
                acceptedFiles: "{{ implode(',', UploadServiceProvider::getTypeRule($fileType, "acceptedFiles")) }}",
                init: function () {
                    this.on("complete", function (file) {
                        console.log(this.getAcceptedFiles());
                        window.tf = this.getAcceptedFiles();
                    });
                }
            });
        });
    </script>
@append
{{-- end -- scripts for uploader --}}
