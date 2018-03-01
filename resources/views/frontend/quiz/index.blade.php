@extends('frontend.layout.master')

@push('styles')
	<style type="text/css">
		.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
	</style>
@endpush

@section('content')
<div id="app">
	<div class="container">
	<alert v-if="answerResult.isVisible" :message="answerResult.message" :icon="answerResult.icon" :alert-class="answerResult.answerClass"></alert>
		<div class="card border-primary mb-3" style="max-width: 18rem;" v-for="(quiz,index) in quizzes.data">
		  <div class="card-header">Pertanyaan @{{ index  }}</div>
		  <div class="card-body text-primary">
		    <h5 class="card-title">Kategori</h5>
		    <p class="card-text" v-html="quiz.description"></p>
		    <ul v-for="multiple_choice in quiz.multiple_choice">
		    	<li style="list-style-type: none;"><input type="radio" name="answer" v-model="answer" :value="multiple_choice.answer_choice" /> @{{ multiple_choice.answer_description }}</li>
		    </ul>
		  </div>
		</div>
		@{{ answer }}
		<button class="btn btn-success" @click="checkAnswer" :disabled="answer == ''">Preview</button>
		<button class="btn btn-primary" @click="fetchQuizzes(quizzes.current_page + 1)" :disabled="answer == '' ">Next</button>
	</div>
</div>
@endsection

@push('scripts')
	<script type="text/javascript">
	Vue.component('alert',{
		props:['message','alertClass','icon'],
		template: 	`<div>
						<div class="alert alert-dismissible fade show" :class="alertClass" role="alert">
						  <strong>@{{ message }}</strong> 
						  <span>
								<i :class="icon"></i>
							</span>
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>
					</div>`
	})

		new Vue({
			el:"#app",
			data:{
				answer:'',
				quizzes:[],
				answerResult:{
					message:'',
					answerClass:'',
					icon:'',
					isVisible:false
				}
			},
			mounted(){
				this.fetchQuizzes(1)
			},
			methods:{
				fetchQuizzes(page){
					this.answer = ''
					this.answerResult.isVisible=false;
					axios.get('api/question?page='+page).then(response=>{
						this.quizzes = response.data;
					})
				},
				checkAnswer(){

					let answer=this.answer === this.quizzes.data[0].answer.answer;
					
					if(answer){
						this.answerResult.message="Jawaban Anda Benar !!!";
						this.answerResult.answerClass="alert-success";
						this.answerResult.icon = 'far fa-smile';
					}else{
						this.answerResult.message="Jawaban Anda Salah !!!";
						this.answerResult.answerClass="alert-danger";
						this.answerResult.icon = 'far fa-frown';
					}

					this.answerResult.isVisible=true;

				}
			}
		})
	</script>
@endpush