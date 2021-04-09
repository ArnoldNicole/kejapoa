<template>
	<div>
		<a @click="openChat" class="float">
		<i class="fa fa-envelope my-float"></i>
		</a>
		<div class="label-container">
		<div class="label-text">Talk to Us</div>
		<i class="fa fa-play label-arrow"></i>
		</div>


		<!-- Help Modal -->
		<div class="chat-popup" id="chat_form">
		<form @submit.prevent="sendMessage" class="form-container">
		  <h4>Chat</h4>
		  <div v-if="messages!=[]">
		  	<p v-for="message in messages">{{message.message}}</p>
		  </div>		  
		  <div v-if="chat_data==null">
		  	<input type="email" v-model="help.email" placeholder="Enter Email" class="form-control" required>
		  	<hr>
		  	<input type="name" v-model="help.name" placeholder="Enter Name" class="form-control" required>
		  	<hr>
		  </div>			  		  
		  <textarea v-model="help.message" placeholder="Type message.." rows="3"  required></textarea>
		  <button  class="btn btn-small" :disabled="isSending" type="submit">Send</button>
		  <button @click="closeChat"  class="btn btn-small cancel">Close</button>		  
		</form>
		</div>
	</div>
</template>
<script>
	export default{
		props:['chat_data'],
		data(){
			return {
				HelpModal:false,
				isSending:false,
				messages:[],
				initial:false,
				help:{
					email:'',
					name:'',
					message:'',
				}				
			}
		},
		methods:{
			openChat(){
				document.getElementById('chat_form').style.display = "block";
				
			},
			closeChat(){
				document.getElementById('chat_form').style.display = "none";
			},
			async sendMessage(){
				this.isSending = true				
				if (this.help.message.trim()=="") {
					this.isSending = false
					return this.e('please provide an email')
				}

				const res = await this.callApi('post','/user/get/help/home', this.help)

				if (res.status == 201) {
					this.e('Thank you for your message, please hold as one of our agents gets to you')
					this.isSending = false
					this.messages.unshift(this.help)
					let obj ={email:'',	name:'', message:''	}
					this.help = obj					
				}else{
					this.isSending = false
					if (res.status ==422) {
						for (let i in res.data.errors) {
							this.e(res.data.errors[i][0])
						}
					}else{
						this.swr()
					}
				}
			}			
		},
		created(){
			this.initial = true;
		}
	}
</script>

<style scoped>
	.chat-popup{
		display: none;
		 position: fixed !important;
		 bottom: 0 !important;
		 right: 15px !important;
		 border: 3px solid #f1f1f1 !important;
		 z-index: 9 !important;
		 height: 450px;
		 overflow-y: scroll;
	}
	.form-container {
	  max-width: 300px;
	  padding: 10px;
	  background-color: white;
	}

	/* Full-width textarea */
	.form-container textarea {
	  width: 100%;
	  padding: 15px;
	  margin: 5px 0 22px 0;
	  border: none;
	  background: #f1f1f1;
	  resize: none;
	  min-height: 150px;
	}

	/* When the textarea gets focus, do something */
	.form-container textarea:focus {
	  background-color: #ddd;
	  outline: none;
	}

	/* Set a style for the submit/send button */
	.form-container .btn {
	  background-color: #4CAF50;
	  color: white;
	  padding: 16px 20px;
	  border: none;
	  cursor: pointer;
	  width: 100%;
	  margin-bottom:10px;
	  opacity: 0.8;
	}

	/* Add a red background color to the cancel button */
	.form-container .cancel {
	  background-color: red;
	}

	/* Add some hover effects to buttons */
	.form-container .btn:hover, .open-button:hover {
	  opacity: 1;
	}
</style>