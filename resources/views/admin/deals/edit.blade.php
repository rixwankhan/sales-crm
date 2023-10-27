@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.deal.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.deals.update", [$deal->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="deal_name">{{ trans('cruds.deal.fields.deal_name') }}</label>
                <input class="form-control {{ $errors->has('deal_name') ? 'is-invalid' : '' }}" type="text" name="deal_name" id="deal_name" value="{{ old('deal_name', $deal->deal_name) }}" required>
                @if($errors->has('deal_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('deal_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deal.fields.deal_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="contact_name_id">{{ trans('cruds.deal.fields.contact_name') }}</label>
                <select class="form-control select2 {{ $errors->has('contact_name') ? 'is-invalid' : '' }}" name="contact_name_id" id="contact_name_id">
                    @foreach($contact_names as $id => $entry)
                        <option value="{{ $id }}" {{ (old('contact_name_id') ? old('contact_name_id') : $deal->contact_name->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('contact_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contact_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deal.fields.contact_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="source_id">{{ trans('cruds.deal.fields.source') }}</label>
                <select class="form-control select2 {{ $errors->has('source') ? 'is-invalid' : '' }}" name="source_id" id="source_id">
                    @foreach($sources as $id => $entry)
                        <option value="{{ $id }}" {{ (old('source_id') ? old('source_id') : $deal->source->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('source'))
                    <div class="invalid-feedback">
                        {{ $errors->first('source') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deal.fields.source_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="stage_id">{{ trans('cruds.deal.fields.stage') }}</label>
                <select class="form-control select2 {{ $errors->has('stage') ? 'is-invalid' : '' }}" name="stage_id" id="stage_id" required>
                    @foreach($stages as $id => $entry)
                        <option value="{{ $id }}" {{ (old('stage_id') ? old('stage_id') : $deal->stage->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('stage'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stage') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deal.fields.stage_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount">{{ trans('cruds.deal.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $deal->amount) }}" step="0.01">
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deal.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="closing_date">{{ trans('cruds.deal.fields.closing_date') }}</label>
                <input class="form-control date {{ $errors->has('closing_date') ? 'is-invalid' : '' }}" type="text" name="closing_date" id="closing_date" value="{{ old('closing_date', $deal->closing_date) }}">
                @if($errors->has('closing_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('closing_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deal.fields.closing_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.deal.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $deal->description) !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deal.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attachments">{{ trans('cruds.deal.fields.attachments') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}" id="attachments-dropzone">
                </div>
                @if($errors->has('attachments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('attachments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deal.fields.attachments_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="products">{{ trans('cruds.deal.fields.products') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('products') ? 'is-invalid' : '' }}" name="products[]" id="products" multiple>
                    @foreach($products as $id => $product)
                        <option value="{{ $id }}" {{ (in_array($id, old('products', [])) || $deal->products->contains($id)) ? 'selected' : '' }}>{{ $product }}</option>
                    @endforeach
                </select>
                @if($errors->has('products'))
                    <div class="invalid-feedback">
                        {{ $errors->first('products') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deal.fields.products_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.deals.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $deal->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    var uploadedAttachmentsMap = {}
Dropzone.options.attachmentsDropzone = {
    url: '{{ route('admin.deals.storeMedia') }}',
    maxFilesize: 20, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
      uploadedAttachmentsMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedAttachmentsMap[file.name]
      }
      $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($deal) && $deal->attachments)
          var files =
            {!! json_encode($deal->attachments) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection