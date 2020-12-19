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
	                 
</style>

<template>
	<div class="container">
		<Row>
			<Col span="6">
			<Card>
				<p slot="title">Chats</p>
			</Card>
			</Col>

			<Col span="18">
				<Card>
					<p slot="title">Kejapoa Chat area <span class="float-right text-info font-weight-bold">sending to {{user.name}} {{user.id}}</span>
					</p>
					<div class="card-body height3">
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
				<Form>
					<FormItem prop="message">
					    <Input type="text" v-model='data.message'  placeholder="Enter your message">
					        <Icon type="md-mail" slot="prepend"></Icon>
					    </Input>
					</FormItem>
					<FormItem>
						<Button @click="sendMessage">Send</Button>
					</FormItem>
					{{authUserId}}
				</Form>
				</Card>
			</Col>
		</Row>
	</div>
</template>
<script>
	export default {
		props:['authUserId'],
		data(){
			return{
			user:[], //logged in user
			receiver:[],//user chatting with
			data:{
				message:'',
				user_id:'',				
			},
			contacts:[],
			conversation:[],
			}
		},
		methods:{
			async sendMessage(){
				if (this.data.message.trim()=='') {
					return this.e('Please write something')
				}
				const res =  await this.callApi('post', '/user/sendMessage', this.data)
				if (res.status==200) {					
					this.s('Message sent')
					//this.conversation.push(res.data);
					this.data.message=''			
				}else{
					if(res.status==422){
						if (res.data.errors.message) {
							this.e(res.data.errors.message[0])
						}
					}else{
						if (res.status === 401) {
							this.e(res.data.message)
						}else{
							this.swr('Unknown error ocuured')
						}
					}
				}
			},
			listen(){
				window.Echo.private("chatroom."+this.user.id)
				    .listen('.message.new', (e) => {
				        console.log(e);
				    });			      
			    }
		},
		async mounted(){
			const responseData= await this.callApi('get', '/user/profileData')
			if (responseData.status === 200) {			
				this.user = responseData.data.data
			}
			else{
				this.e('Something went wrong while loading messages')

			}

			this.listen();
		},
		async created(){
			//get the messages from this conversation with the user in parameter 
			this.data.user_id = this.$route.params.id
			const res= await this.callApi('get', '/user/fetchmessages/'+this.$route.params.id)
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
			//const response = await this.callApi('get', '/user/contacts/'+this.$route.params.id)
			//if (response.status === 200) {			
			//	this.contacts = response.data
			//}else{
			//	this.swr('Error fetching your contacts');
			//}
			//get the users conversation
			
			
		}
	}
</script>

