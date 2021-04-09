<style>
	body{
	    background:#eee;    
	}
	.chat-list {
	    padding: 0;
	    font-size: .8rem;
	}

	.chat-list li {
	    margin-bottom: 10px;
	    overflow: auto;
	    color: #ffffff;
	}

	.chat-list .chat-img {
	    float: left;
	    width: 48px;
	}

	.chat-list .chat-img img {
	    -webkit-border-radius: 50px;
	    -moz-border-radius: 50px;
	    border-radius: 50px;
	    width: 100%;
	}

	.chat-list .chat-message {
	    -webkit-border-radius: 50px;
	    -moz-border-radius: 50px;
	    border-radius: 50px;
	    background: #5a99ee;
	    display: inline-block;
	    padding: 10px 20px;
	    position: relative;
	}

	.chat-list .chat-message:before {
	    content: "";
	    position: absolute;
	    top: 15px;
	    width: 0;
	    height: 0;
	}

	.chat-list .chat-message h5 {
	    margin: 0 0 5px 0;
	    font-weight: 600;
	    line-height: 100%;
	    font-size: .9rem;
	}

	.chat-list .chat-message p {
	    line-height: 18px;
	    margin: 0;
	    padding: 0;
	}

	.chat-list .chat-body {
	    margin-left: 20px;
	    float: left;
	    width: 70%;
	}

	.chat-list .in .chat-message:before {
	    left: -12px;
	    border-bottom: 20px solid transparent;
	    border-right: 20px solid #5a99ee;
	}

	.chat-list .out .chat-img {
	    float: right;
	}

	.chat-list .out .chat-body {
	    float: right;
	    margin-right: 20px;
	    text-align: right;
	}

	.chat-list .out .chat-message {
	    background: #fc6d4c;
	}

	.chat-list .out .chat-message:before {
	    right: -12px;
	    border-bottom: 20px solid transparent;
	    border-left: 20px solid #fc6d4c;
	}

	.card .card-header:first-child {
	    -webkit-border-radius: 0.3rem 0.3rem 0 0;
	    -moz-border-radius: 0.3rem 0.3rem 0 0;
	    border-radius: 0.3rem 0.3rem 0 0;
	}
	.card .card-header {
	    background: #17202b;
	    border: 0;
	    font-size: 1rem;
	    padding: .65rem 1rem;
	    position: relative;
	    font-weight: 600;
	    color: #ffffff;
	}

	.content{
	    margin-top:40px;    
	}
	.online {
	      height: 15px;
	      width: 15px;
	      background-color: #008000;
	      border-radius: 50%;
	      display: inline-block;
	      margin-bottom: -4px;
	      border: 1px solid white;
	    }

	  .offline {
	        height: 15px;
	        width: 15px;
	        background-color: red;
	        border-radius: 50%;
	        display: inline-block;
	        margin-bottom: -4px;
	        border: 1px solid white;
	      }
	      .auto{	      	
	      	height: 70%;
	      	overflow-y: scroll;
	      }
	      ::-webkit-scrollbar {
	          display: none;
	      }
	                 
</style>

<template>
	<div class="container">
		<Row :gutter="16">
			<Col span="6">
			<Card>
				<contacts></contacts>
			</Card>
			</Col>

			<Col span="17">
				<Card>
					<p slot="title">
					 KEJAPOA CONVERSATION	with {{recipient.name}}				
					</p>
					<div class="height3 auto">
							        			<ul class="chat-list" v-for="message in conversation">
							        				<li class="in" v-if="message.from_user==data.user_id">
							        					<div class="chat-body">
							        						<div class="chat-message">	
							        							<p>{{message.content}}<br><small>{{message.created_at}}</small></p>
							        						</div>
							        					</div>
							        				</li>
							        				<li class="out" v-else>
							        					<div class="chat-body">
							        						<div class="chat-message">
							        							<p>{{message.content}}<br><small>{{message.created_at}}</small></p>
							        						</div>
							        					</div>
							        				</li>

							        			</ul>
							        		</div>
				<Form @submit.native.prevent inline >
					<FormItem prop="message" class="w-75">
					    <Input type="text" v-model='data.message'  placeholder="Enter your message">
					        <Icon type="md-mail" slot="prepend"></Icon>
					       
					    </Input>
					</FormItem>
					<FormItem>
						<Button @click="sendMessage" :disabled="isActive" type="default"> <Icon type="ios-send" color="aqua" size="30"></Icon></Button>
					</FormItem>


					
						
					
					
				</Form>
				</Card>
			</Col>
		</Row>
	</div>
</template>
<script>
import contacts from'./contacts.vue'
	export default {			  
		data(){
			return{			
			data:{
				message:'',
				user_id:this.recipient.id,				
			},
			contacts:[],
			conversation:[],
			isActive: false,
			}
		},  
		components:{contacts},  
		methods:{
			async sendMessage(){
				this.isActive=true
				if (this.data.message.trim()=='') {
					return this.e('Please type your message')
					this.isActive=false
				}
				
				const res =  await this.callApi('post', '/user/sendMessage', this.data)
				if (res.status==200) {					
					this.s('Message sent')
					this.conversation.push(res.data);
					this.data.message=''
					this.isActive=false					

				}else{
					if(res.status==422){
						if (res.data.errors.message) {
							this.e(res.data.errors.message[0])
						}
					}else{
							this.e(res.data.message)
						}
					}
				},
				async listen(){

					 Echo.private('chatroom')					    
					     .listen('NewMessage', (message) => {
					     if (message.from_user == this.recipient.id && message.to_user == this.sender.id) {
					     	this.conversation.push(message)
					     }
					     });		    						

								      
				    }
			},



		props:['sender','recipient'],		
		async mounted(){
			this.listen();
			},




		async created(){
			const res = await this.callApi('get', '/user/fetchmessages/'+this.recipient.id)
			if (res.status === 200) {			
				this.conversation = res.data
			}else{
				if (res.status === 401) {
					this.e(res.data.message)
					this.conversation = []
					
				}
				if (res.status === 404) {
					this.e(res.data.message)
				}
			}			
		
			
		}
	}
</script>

