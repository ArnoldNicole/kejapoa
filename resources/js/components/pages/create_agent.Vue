<template>
          <div class="container-fluid">
          <Row>
          	<Col span="18">

          	<Card>
          	    <p slot="title">Add an agent to your profile</p>
          	    <Form>
          	        <FormItem prop="username" label="Username">
          	            <Input type="text" v-model="newAgentData.username" placeholder="Username" required>
          	                <Icon type="ios-person-outline" slot="prepend"></Icon>
          	            </Input>
          	        </FormItem>

          	        <FormItem prop="email" label="Email">
          	            <Input type="email" v-model="newAgentData.email" placeholder="Registered email" required>
          	                <Icon type="md-mail" slot="prepend"></Icon>
          	            </Input>
          	        </FormItem>

          	         <FormItem prop="salary" label="Salary">
          	            <Input type="number" v-model="newAgentData.salary" placeholder="Offered Salary" min="100" required>
          	                <Icon type="md-mail" slot="prepend"></Icon>
          	            </Input>
          	        </FormItem>

          	        <FormItem label="Gender" prop="gender">
          	                    <RadioGroup v-model="newAgentData.gender">
          	                        <Radio label="male">Male</Radio>
          	                        <Radio label="female">Female</Radio>
          	                    </RadioGroup>
          	        </FormItem>

          	        <FormItem prop="dateOfBirth" label="Date of Birth">
          	             <Input type="date" v-model="newAgentData.dateOfBirth">          	            	
          	            </DatePicker>
          	                <Icon type="md-calendar" slot="prepend"></Icon>
          	            </Input>
          	        </FormItem>

          	        <FormItem>
          	            <Button type="primary" @click="CreateAgent">Submit Data</Button>
          	        </FormItem>
          	    </Form>

          	</Card>
          </Col>


          <Col span="6">
          <Card>
          	<p slot="title">MY AGENTS</p>
          	<div v-for="(agent, i) in myagents" :key="i" v-if="myagents.length">
          		<p>{{agent.username}}</p>
          	</div>
          	<div v-else>
          	<p>You currently do not have any agents</p>
          </div>
          </Card>
     	 </Col>
          </Row>
          </div>       
</template>
<script>
	export default {
		data(){
			return {
				newAgentData: {
					username:'',
					email:'',
					gender:'',
					dateOfBirth:'',
					salary:''

				},
				myagents:[],	
			}
		},
		methods:{
			async CreateAgent(){				
				if (this.newAgentData.username.trim()=='') {
					return this.e('Please provide a username')
				}
				if (this.newAgentData.email.trim()=='') {
					return this.e('Email is required')
				}
				if (this.newAgentData.gender.trim()=='') {
					return this.e('Select gender')
				}
				if (this.newAgentData.dateOfBirth.trim()=='') {
					return this.e('Select a date')
				}
				if (this.newAgentData.salary.trim()=='') {
					return this.e('Provide some salary')
				}
				const res= await this.callApi('post', '/landlord/addAgent', this.newAgentData)
				if (res.status==200) {					
					this.s('Agent added, go to add priviledges')
					this.newAgentData.username = '';
					this.newAgentData.email = '';
					this.newAgentData.gender = '';
					this.newAgentData.dateOfBirth = '';
					this.newAgentData.salary = '';
					this.myagents.unshift(res.data);					
				}else{
					if (res.status==422) {
						if (res.data.errors.username) {
							this.e(res.data.errors.username[0])
						}
						if (res.data.errors.email) {
							this.e(res.data.errors.email[0])
						}
						if (res.data.errors.gender) {
							this.e(res.data.errors.gender[0])
						}
						if (res.data.errors.dateOfBirth) {
							this.e(res.data.errors.dateOfBirth[0])
						}
						if (res.data.errors.salary) {
							this.e(res.data.errors.salary[0])
						}
					}
					else{
						if (res.status==401) {
							this.e('Your session ended unexpectedly.')
							window.location='/profile';
						}
							else{
								this.swr('Unexpectd error occured')
							}
						
					}
				}
			}
		},
		async created(){
			const res= await this.callApi('get', '/landlord/myagents')
					if (res.status === 200) {						
						this.myagents = res.data
					}
					else{
						this.e('Something went wrong while loading agents')
					}
		}
	}
</script>