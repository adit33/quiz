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
	<div class="row">
		<div class="col-sm-2">
		<!-- 	<div v-for="(quiz,index) in quizzes">
			@{{ quiz.id }} -->
		</div>
		</div>
		<div class="col-sm">
			
			<alert v-if="answerResult.isVisible" :message="answerResult.message" :icon="answerResult.icon" :alert-class="answerResult.answerClass"></alert>

		<div  :class="{'animated bounce' : quizzes.length != 0 }" class="card border-primary mb-3" style="max-width: 18rem;" v-for="question in question">
		  <div class="card-header">Pertanyaan </div>
		  <div class="card-body text-primary">
		    <h5 class="card-title">Kategori</h5>
		    <p class="card-text" v-html="question.description"></p>
		    <ul v-for="multiple_choice in question.multiple_choice">
		    	<li style="list-style-type: none;"><input type="radio" name="answer" v-model="answer" :value="multiple_choice.answer_choice" /> @{{ multiple_choice.answer_description }}</li>
		    </ul>
		  </div>
		</div>
		<button class="btn btn-success" @click="checkAnswer" :disabled="answer == ''">Preview</button>
		<button class="btn btn-primary" @click="nextPage()">Next</button>

		</div>
	</div>

	
	</div>
</div>
@endsection

@push('scripts')
	<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
	<script type="text/javascript">	

	// const Home = {template:'<div>Home</div>'};

	// const Foo = {template:'<div>Foo</div>'};	

	// const routes = {};

	// const router = new VueRouter({
	// 	mode: 'history',
	// 	 routes:[
	// 	    { path: '/', component: Home },
	// 	    { path: '/foo', component: Foo }
	// 	  ]
	// })

	Vue.component('alert',{
		props:['message','alertClass','icon'],
		template: 	`<div class="animated bounceIn">
						<div class="alert alert-dismissible fade show"  :class="alertClass" role="alert">
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
				question:[],
				quizzes:'',
				perPage:1,
				answerResult:{
					message:'',
					answerClass:'',
					icon:'',
					isVisible:false
				}
			},
			mounted(){
				this.fetchQuizzes()
			},
			methods:{
				fetchQuizzes(){
					this.answer = ''
					this.quizzes="";
					this.answerResult.isVisible=false;
					setTimeout(()=> { //untuk eksekusi delay 
						axios.get('api/question').then(response=>{
						// if (typeof(Strorage) === 'undefined') {
							localStorage.setItem("quizzes",JSON.stringify(response.data))
						// }
					}).then(this.changeQuestion(1))
						.catch(error=>{

						})
					}, 500); // selama satu detik
				},
				changeQuestion(page){
					perPage=this.perPage
					let numPage=this.numberPage()
					let questions=JSON.parse(localStorage.getItem('quizzes'));
					if (page < 1) page = 1;
					if (page > numPage) numPage;
					
					
					for (let i = (page-1)*perPage; i < (page * perPage); i++) {
						this.question.push(questions[i]);
					}

				},
				getQuestion(index){
					let questions=JSON.parse(localStorage.getItem("quizzes"));
					this.question=questions[0];
				},
				nextPage(){
					let currentPage=1;
					let numberPage=this.numberPage()
					if(currentPage > 1) currentPage = numberPage;
					currentPage ++;
					this.changeQuestion(currentPage);

				},
				numberPage(){
					perPage=this.perPage
					let questions=JSON.parse(localStorage.getItem('quizzes'));
					let numPage=Math.ceil(questions.length / perPage);
					return numPage;
				},
				checkAnswer(){
					this.answerResult.isVisible=false;
					setTimeout(()=> {
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
					}, 500);

				}
			}
		});
	</script>
@endpush