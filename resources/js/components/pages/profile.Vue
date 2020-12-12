<template>
	<div>
		<div class="row justify-content-center">			
				<div class="col-md-10">
					<div class="card">
						<div class="card-header bg-light">
							Welcome {{user.username}}
							<span class="float-right">You are logged in as: <span v-if="user.is_landlord">Landlord</span> <span v-else>User</span></span>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-3">
									<div class="demo-avatar">
									   <img v-bind:src="user.profile_image" v-bind:alt=" user.profile_image" class="w-50 rounded-circle">	
									 </div>
									 <Button to="/user/editImage" :avatar-image="user.profile_image"><Icon type="md-edit"/>Edit Image</Button>
								</div>
								<div class="col-9">
									<p class="font-weight-bold text-success">Email:<span class="font-weight-bold text-info">{{user.email}}</span> </p>
									<p class="font-weight-bold text-success">Name:<span class="font-weight-bold text-info">{{user.name}}</span> </p>
									<p class="font-weight-bold text-success">verification status:<span class="font-weight-bold text-info">{{user.is_verified}}</span> </p>									
								</div>
							</div>
						</div>
					</div>
				</div>	
		</div>
		<div class="row justify-content-center">

		<div class="col-md-8 float-left">
			<Row justify="center">
				<Col span="6">
					<Button @click="editContactInfo(user)" type="default">
						<Icon type="md-create"/>Edit Contact Info
					</Button>
				</Col>
				<Col span="18">
					<Card>
						<p slot="title">Contact Data</p>
						<div class="pt-2 font-weight-bold">Mobile<Icon type="ios-phone-portrait"/>{{ user.contact.phone_number}}</div>

						<div class="pt-2 font-weight-bold">Postal Address<Icon type="ios-locate"/><br>{{ user.contact.postal_box}} - {{user.contact.postal_code}}</div>

						<div class="pt-2 font-weight-bold"><Icon type="ios-home-outline"/>{{ user.contact.town}}</div>
					</Card>
					<Modal 
						v-model="editContactModal"
						title="Contact Data Update Form"
						:mask-closable='false'
						:closable='false'
						:fullscreen='false'>
						<Form>
							<FormItem prop="phone_number" label="Enter your phone number">
							    <Input type="text" v-model="editData.phone_number" placeholder="Enter a valid Kenyan phone number">
							        <Icon type="md-mail" slot="prepend"></Icon>
							    </Input>
							</FormItem>

							<FormItem prop="postal_box" label="Enter Post Office Box">
							    <Input type="number" v-model="editData.postal_box" placeholder="Enter a mail box we can use to reach you">
							    <Icon type="md-mail" slot="prepend"></Icon>
							    </Input>
							</FormItem>

							<FormItem prop="postal_code" label="Enter Post Office Box Code">
							    <Input type="number" v-model="editData.postal_code" placeholder="Enter the postal Code ">
							    <Icon type="ios-book" slot="prepend"></Icon>
							    </Input>
							</FormItem>

							<FormItem prop="town" label="Enter Your Home Town">
							    <Input type="text" v-model="editData.town" placeholder="Enter your town">
							    <Icon type="ios-book" slot="prepend"></Icon>
							    </Input>
							</FormItem>
						</Form>

						<div slot="footer">
							<Button type="error" @click="editContactModal=false">Close</Button>
							<Button type="info" @click='saveContactInfo'>Save Changes</Button>						
						</div>
					</Modal>
				</Col>
			</Row>
		</div>			
		</div>
	</div>
</template>
<script>
	export default {
		data (){
			return {
				user:[],
				editData:{
					user_id:'',
					phone_number:'',
					postal_box:'',
					postal_code:'',
					town:''
				},
				editContactModal:false

			}
		},
		methods:{
			editContactInfo(user){
				let object = {
					user_id:user.id,
					phone_number:user.contact.phone_number,
					postal_box:user.contact.postal_box,
					postal_code:user.contact.postal_code,
					town:user.contact.town,
				}

				this.editData = object
				this.editContactModal = true				
			},
			async saveContactInfo(){
				if (this.editData.phone_number.trim()=='') {
					return this.e('Please provide your phone number')
				}

				if (this.editData.postal_box.trim()=='') {
					return this.e('Please provide a post box')
				}

				if (this.editData.postal_code.trim()=='') {
					return this.e('Please provide your postal code')
				}
				if (this.editData.town.trim()=='') {
					return this.e('Please provide your Town')
				}

			const res= await this.callApi('post', '/user/editContactData', this.editData)
			if (res.status==200) {
				this.user.contact=res.data
				this.editData = [];
				this.editContactModal= false

			}else{
				if (res.data.errors.phone_number) {
					this.e(res.data.errors.phone_number[0])
				}
				if (res.data.errors.postal_box) {
					this.e(res.data.errors.postal_box[0])
				}
				if (res.data.errors.postal_code) {
					this.e(res.data.errors.postal_code[0])
				}
				if (res.data.errors.town) {
					this.e(res.data.errors.town[0])
				}
			}
		}
	},

		async created(){
		const res= await this.callApi('get', '/user/profileData')
		if (res.status === 200) {			
			this.user = res.data.data
		}
		else{
			this.e('Something went wrong while loading houses')
		}
	}
}
	
</script>