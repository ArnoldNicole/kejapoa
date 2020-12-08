<template>
	<div>
		<Row justify="center">
			<Col span=18>
				<Card>
					<p slot="title">Register as a landlord by filling this form</p>
					<Form>
						<FormItem prop="name" label="Full Names">
						    <Input type="text" v-model="newUser.name" placeholder="Full Legal Names">
						        <Icon type="ios-person-outline" slot="prepend"></Icon>
						    </Input>
						</FormItem>

						<FormItem prop="username" label="Choose a username">
						    <Input type="text" v-model="newUser.username" placeholder="Full Legal Names">
						        <Icon type="ios-person-outline" slot="prepend"></Icon>
						    </Input>
						</FormItem>

						<FormItem prop="email" label="Enter your email">
						    <Input type="email" v-model="newUser.email" placeholder="Enter Valid Email Address">
						        <Icon type="md-mail" slot="prepend"></Icon>
						    </Input>
						</FormItem>

						<FormItem prop="krapin" label="KRA PIN">
						    <Input type="text" v-model="newUser.krapin" placeholder="Enter KRA PIN">
						        <Icon type="ios-person-outline" slot="prepend"></Icon>
						    </Input>
						</FormItem>

						<FormItem prop="password" label="Enter Password">
						    <Input type="password" v-model="newUser.password" placeholder="Enter a password">
						        <Icon type="ios-person-outline" slot="prepend"></Icon>
						    </Input>
						</FormItem>

						<FormItem prop="password-confirm" label="Confirm Password">
						    <Input type="password" v-model="newUser.password_confirmation" placeholder="Confirm Password">
						        <Icon type="ios-person-outline" slot="prepend"></Icon>
						    </Input>
						</FormItem>

						<FormItem>
						    <Button type="primary" @click="CreateLandlord">Submit Data</Button>
						</FormItem>

					</Form>
				</Card>
			</Col>
		</Row>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				newUser: {
					name:'',
					username:'',
					email:'',					
					password:'',
					krapin:'',
					password_confirmation:''
				}					
			}
		},
		methods:{
			async CreateLandlord(){				
				if (this.newUser.name.trim()=='') {
					return this.e('Please provide a Full Name')
				}
				if (this.newUser.email.trim()=='') {
					return this.e('Email is required')
				}
				if (this.newUser.krapin.trim()=='') {
					return this.e('Input a valid Kra Pin')
				}
				if (this.newUser.username.trim()=='') {
					return this.e('Enter a username')
				}
				if (this.newUser.password.trim()=='') {
					return this.e('Provide enter a password')
				}
				if (this.newUser.password.trim()=='') {
					return this.e('Provide confirm password')
				}
				
				const res= await this.callApi('post', '/landlord/new', this.newUser)
				if (res.status==200) {					
					this.s('Agent added, go to add priviledges')
					this.newUser= [];					
					window.location='/profile'					
				}else{
					if (res.status==422) {
						if (res.data.errors.username) {
							this.e(res.data.errors.username[0])
						}
						if (res.data.errors.email) {
							this.e(res.data.errors.email[0])
						}
						if (res.data.errors.name) {
							this.e(res.data.errors.name[0])
						}
						if (res.data.errors.krapin) {
							this.e(res.data.errorskrapinh[0])
						}
						if (res.data.errors.password) {
							this.e(res.data.errors.password[0])
						}
					}
					else{
						this.swr('Unexpectd error occured')
					}
				}
			}
		}

	}
</script>