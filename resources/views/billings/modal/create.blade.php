<div class="modal fade" id="addBillingsModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Tambah data tagihan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
         </div>
         <div class="modal-body">
            <form action="{{ route('billings.store') }}" method="POST" id="addBillingsForm">
               @csrf
               <div class="row">
                  <div class="col-md-12">
                     <div class="mb-3">
                        <label for="name" class="form-label">Nama Siswa</label>
                        <select class="form-select select2 @error('student_id') is-valid @enderror" name="student_id[]" multiple>
                           @foreach($students as $student)
                              <option value="{{ $student->id }}" {{ collect(old('student_id')) -> contains($student->id) ? 'selected' : ''}}>
                                 {{ $student->identification_number }} - {{ $student->name}}
                              </option>
                           @endforeach
                        </select>

                        @error('student_id')
                           <div class="d-block"> {{ $message }} </div>
                        @enderror
                     </div>
                  </div>
               </div>

               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
