@if($post->canRecieveComments())
    {!! Form::open([
        'url' => \App\Providers\SettingServiceProvider::getLocale() . "/comment",
        'method'=> 'post',
        'class' => 'js',
        'name' => 'commentForm',
        'id' => 'commentForm',
        'style' => 'padding: 15px;',
    ]) !!}
    <div class="row">
        @include('forms.hidden',[
            'name' => 'post_id',
            'value' => $post->id,
        ])

        @include('forms.input', [
            'name' => 'name',
            'label' => false,
            'placeholder' => trans('validation.attributes.first_and_last_name'),
            'class' => 'form-required',
        ])


        @include('forms.input', [
            'name' => 'email',
            'label' => false,
            'placeholder' => trans('validation.attributes.email'),
            'class' => 'form-required',
        ])

        @include('forms.textarea', [
            'name' => 'text',
            'label' => false,
            'rows' => 4,
            'placeholder' => trans('validation.attributes_placeholder.your_comment'),
            'class' => 'form-required',
        ])

        <div class="col-xs-12">
            <div class="form-group pt15">
                <div class="action tal">
                    <button class="btn btn-primary pull-left"> ثبت نظر</button>
                </div>
            </div>
        </div>
        <div class="col-xs-12 pt15">
            @include('forms.feed')
        </div>
    </div>
    {!! Form::close() !!}
@endif