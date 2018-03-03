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
<p>
		 <router-link to="/">/home</router-link>
  <router-link to="/foo">/foo</router-link>
 
</p>
 <router-view></router-view>
		<div v-for="(quiz,index) in quizzes">
			@{{ quiz.id }}
		</div>


		<div v-if="quizzes.length != 0" :class="{'animated bounce' : quizzes.length != 0 }" class="card border-primary mb-3" style="max-width: 18rem;" v-for="(quiz,index) in quizzes">
		  <div class="card-header">Pertanyaan @{{ index  }}</div>
		  <div class="card-body text-primary">
		    <h5 class="card-title">Kategori</h5>
		    <p class="card-text" v-html="quiz.description"></p>
		    <ul v-for="multiple_choice in quiz.multiple_choice">
		    	<li style="list-style-type: none;"><input type="radio" name="answer" v-model="answer" :value="multiple_choice.answer_choice" /> @{{ multiple_choice.answer_description }}</li>
		    </ul>
		  </div>
		</div>
		<button class="btn btn-success" @click="checkAnswer" :disabled="answer == ''">Preview</button>
		<button class="btn btn-primary" @click="fetchQuizzes(quizzes.current_page + 1)" :disabled="answer == '' ">Next</button>
	</div>
</div>
@endsection

@push('scripts')
	<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
	<script type="text/javascript">	

	const Home = {template:'<div>Home</div>'};

	const Foo = {template:'<div>Foo</div>'};	

	const routes = {};

	const router = new VueRouter({
		mode: 'history',
		 routes:[
		    { path: '/', component: Home },
		    { path: '/foo', component: Foo }
		  ]
	})

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
			router,
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
					this.quizzes="";
					this.answerResult.isVisible=false;
					setTimeout(()=> { //untuk eksekusi delay 
						axios.get('api/question?page='+page).then(response=>{
						this.quizzes = response.data;
						localStorage.setItem('quizess',JSON.stringify(response.data));
					})
					}, 500); // selama satu detik
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