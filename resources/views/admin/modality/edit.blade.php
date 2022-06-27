@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.modality.actions.edit', ['name' => $modality->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <modality-form
                :action="'{{ $modality->resource_url }}'"
                :data="{{ $modality->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.modality.actions.edit', ['name' => $modality->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.modality.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </modality-form>

        </div>
    
</div>

@endsection