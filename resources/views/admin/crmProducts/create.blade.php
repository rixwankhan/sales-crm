@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.crmProduct.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.crm-products.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="product_image">{{ trans('cruds.crmProduct.fields.product_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('product_image') ? 'is-invalid' : '' }}" id="product_image-dropzone">
                </div>
                @if($errors->has('product_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmProduct.fields.product_image_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('product_active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="product_active" value="0">
                    <input class="form-check-input" type="checkbox" name="product_active" id="product_active" value="1" {{ old('product_active', 0) == 1 || old('product_active') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="product_active">{{ trans('cruds.crmProduct.fields.product_active') }}</label>
                </div>
                @if($errors->has('product_active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmProduct.fields.product_active_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="product_name">{{ trans('cruds.crmProduct.fields.product_name') }}</label>
                <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" type="text" name="product_name" id="product_name" value="{{ old('product_name', '') }}" required>
                @if($errors->has('product_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmProduct.fields.product_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="product_code">{{ trans('cruds.crmProduct.fields.product_code') }}</label>
                <input class="form-control {{ $errors->has('product_code') ? 'is-invalid' : '' }}" type="text" name="product_code" id="product_code" value="{{ old('product_code', '') }}">
                @if($errors->has('product_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmProduct.fields.product_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="product_category_id">{{ trans('cruds.crmProduct.fields.product_category') }}</label>
                <select class="form-control select2 {{ $errors->has('product_category') ? 'is-invalid' : '' }}" name="product_category_id" id="product_category_id">
                    @foreach($product_categories as $id => $entry)
                        <option value="{{ $id }}" {{ old('product_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('product_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmProduct.fields.product_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_price">{{ trans('cruds.crmProduct.fields.unit_price') }}</label>
                <input class="form-control {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', '') }}" step="0.01">
                @if($errors->has('unit_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unit_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmProduct.fields.unit_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.crmProduct.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description') !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmProduct.fields.description_helper') }}</span>
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
    Dropzone.options.productImageDropzone = {
    url: '{{ route('admin.crm-products.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="product_image"]').remove()
      $('form').append('<input type="hidden" name="product_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="product_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($crmProduct) && $crmProduct->product_image)
      var file = {!! json_encode($crmProduct->product_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="product_image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
                xhr.open('POST', '{{ route('admin.crm-products.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $crmProduct->id ?? 0 }}');
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

@endsection