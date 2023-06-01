@if ($model->status == 'DONE')
  <span class="badge bg-success">
    {{ $model->status }} 
  </span>
@else
  <span class="badge bg-warning">
    {{ $model->status }} 
  </span>
@endif