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
    <quill-editor v-model="questions.description"></quill-editor>
    <p class="text-danger" v-text="errors.get('description')"></p>
  </div>

  <div class="form-group">
    <label for="formGroupExampleInput2">Jenis Pertanyaan</label>
    <select class="custom-select" :class="{ 'is-invalid' : errors.get('question_type_id') }" v-model="questions.question_type_id" @change="errors.clear('question_type_id')">
	  <option selected value="">Jenis Pertanyaan</option>
	  <option value="1">Pilihan Ganda</option>
	  <option value="2">Essay</option>
  	</select>
  	<p class="text-danger" v-text="errors.get('question_type_id')"></p>
  </div>

  <div class="form-group" v-if="questions.question_type_id === '2'">
  	<label>Jawaban</label>
  	<input type="text" name="" class="form-control" />

  </div>

  <div class="form-row"  v-if="questions.question_type_id === '1'" v-for="(n,index) in multiple_choice">
  	<div class="form-group col-md-8" b>
  		<!-- <label>Jawaban @{{ (n+9).toString(36) }}</label> -->
  	  <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">@{{ n.answer_choice }}</div>
        </div>
        <input type="text" class="form-control" :class="{ 'is-invalid' : errors.get('multiple_choice.'+index+'.answer_description') }" v-model="n.answer_description" id="inlineFormInputGroupUsername" :placeholder="'Jawaban '+n.answer_choice" >
        <!-- <input type="radio" v-model="multiple_choice.answer_choice[index]" :value=" (n+9).toString(36) " /> -->
  	</div>
  </div>
   <div class="form-group col-md-4">
	   <div class="form-check">
	  <input class="form-check-input" name="jawaban[]" :class="{ 'is-invalid' : errors.get('multiple_choice.'+index+'.answer_description') }" type="radio" name="exampleRadios" id="exampleRadios1">
	  <label class="form-check-label" for="exampleRadios1">
	   @{{ n.answer_choice }}
	  </label>
	</div>
      <!-- <input type="radio" name="jawaban[]" class="form-control" :class="{ 'is-invalid' : errors.get('multiple_choice.'+index+'.answer_description') }"> -->
    </div>
     <p class="text-danger" v-text="errors.get('multiple_choice.'+index+'.answer_description')"></p>	
  </div>

  <button type="button" class="btn btn-primary" @click="saveQuestion">Simpan</button>

</form>
  </div>
</div>
@endsection

@push('scripts')
	<script type="text/javascript">
		class Errors{
			constructor(){
				this.errors = {};
			}

			get(field){
				if(this.errors[field]){
					return this.errors[field][0];
				}
			}

			clear(field){
				delete this.errors[field];
			}

			record(errors){
				this.errors = errors;
			}
		}

		function getAnswerChoice(){
					let tmp=[];
					for(let i=0;i<4;i++){
						let obj={};
						obj['answer_choice']=(i+10).toString(36);
						obj['answer_description']='';
						tmp.push(obj);
					}
					return tmp;
		}

		new Vue({
			el:"#app",
			data:{
				questions:{
					question_type_id:"",
					description:""
				},
				multiple_choice:this.getAnswerChoice(),
				errors : new Errors(),
			},
			methods:{
				saveQuestion(){
					let url='./';
					axios.post(url,
						{
							description:this.$data.questions.description,
							question_type_id:this.$data.questions.question_type_id,
							multiple_choice:this.$data.multiple_choice,
						})
					.then()
					.catch(error=>{
						this.errors.record(error.response.data.errors);
					})
				}
			},
			computed:{
				choices(){
					let tmp=[];
					for(let i=0;i<4;i++){
						tmp.push((i+10).toString(36))
					}
					return tmp;
				}
			}
		})
	</script>
@endpush

