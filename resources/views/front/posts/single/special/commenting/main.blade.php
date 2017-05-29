@if($post->canRecieveComments())
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <h4>
                    <span class="icon-comment"> </span>
                    {{ $post->title_shown_on_sending_comments }}
                </h4>
            </div>
            <div class="col-xs-12 pb15">
                {!! $post->text  !!}
            </div>

            @if($post->fields)
                {{ null, $fields = explodeNotEmpty(',' , $post->fields) }}
                @foreach($fields as $fieldIndex => $fieldValue)
                    @unset($fields[$fieldIndex])
                    {{ null, $fieldValue = trim($fieldValue) }}

                    @if(str_contains($fieldValue, '*'))
                        {{ null, $fieldValue = str_replace('*', '', $fieldValue) }}
                        {{ null, $tmpField['required'] = true }}
                    @else
                        {{ null, $tmpField['required'] = false }}
                    @endif

                    @if(str_contains($fieldValue, '_label'))
                        {{ null, $fieldValue = str_replace('_label', '', $fieldValue) }}
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
                    {{ null, $fields[$fieldValue] = $tmpField }}
                @endforeach
            @endif

            @include('front.frame.widgets.comment_form', compact('fields'))
            @if($post->show_previous_comments)
                @include($viewFolder . '.previous-comments')
            @endif
        </div>
    </div>
@endif