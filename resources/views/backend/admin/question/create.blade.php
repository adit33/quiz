@extends('backend.layout.master')

@section('content')
	

<div class="card">
  <div class="card-header">
    {{ $title }}
  </div>
  <div class="card-body">
    <form>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Pertanyaan</label>
    <quill-editor v-model="question"></quill-editor>
  </div>

  <div class="form-group">
    <label for="formGroupExampleInput2">Jenis Pertanyaan</label>
    <select class="custom-select" v-model="question_type">
	  <option selected value="">Jenis Pertanyaan</option>
	  <option value="1">Pilihan Ganda</option>
	  <option value="2">Essay</option>
  	</select>
  </div>

  <div class="form-group" v-if="question_type === '2'">
  	<label>Jawaban</label>
  	<input type="text" name="" class="form-control" />

  </div>

  <div class="form-row"  v-if="question_type === '1'" v-for="(n,index) in 4">
  	<div class="form-group col-md-8" b>
  		<!-- <label>Jawaban @{{ (n+9).toString(36) }}</label> -->
  	  <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">@{{ (n+9).toString(36) }}</div>
        </div>
        <input type="text" class="form-control" id="inlineFormInputGroupUsername" :placeholder="'Jawaban '+(n+9).toString(36)">
  	</div>
  </div>
   <div class="form-group col-md-4">
      <input type="radio" name="jawaban[]" >
    </div>	
  </div>

  <button type="button" class="btn btn-primary" @click="saveQuestion">Simpan</button>

</form>
  </div>
</div>
@endsection

@push('scripts')
	<script type="text/javascript">
		new Vue({
			el:"#app",
			data:{
				question_type:"",
				question:""
			},
			methods:{
				saveQuestion(){
					let url='./';
					axios.post(url,{description:this.question})
				}
			}
		})
	</script>
@endpush

