<template>
	<div>
		<div class="row justify-content-center">			
				<div class="col-md-12">
					<div class="card">
						<div class="card-header bg-info">
							Welcome {{user.username}}
							<p class="float-right"><span v-if="user.is_landlord">You are logged in as Landlord</span>
							</p>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-4">	
								<profile-photo/>
									 <Button @click="editContactInfo(contact)" type="default">
									 	<Icon type="md-create"/>Edit Contact Info
									 </Button>
								</div>
								<div class="col-sm-8">
									<p class="font-weight-bold text-success">Email:<span class="font-weight-bold text-info">{{user.email}}</span> </p>
									<p class="font-weight-bold text-success">Name:<span class="font-weight-bold text-info">{{user.name}}</span> </p>
									<p class="font-weight-bold text-success">verification status:<span class="font-weight-bold text-info">{{user.is_verified}}</span> </p>

									<hr>
									<Card v-if="user">
										<p slot="title">Contact Data</p>
										<div class="pt-2 font-weight-bold">Mobile<Icon type="ios-phone-portrait"/>{{ contact.phone_number}}</div>

										<div class="pt-2 font-weight-bold">Postal Address<Icon type="ios-locate"/><br>{{ contact.postal_box}} - {{contact.postal_code}}</div>

										<div class="pt-2 font-weight-bold"><Icon type="ios-home-outline"/>{{ contact.town}}</div>
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

								</div>
							</div>
						</div>
					</div>
				</div>	
		</div>	

		<div class="myrow" v-if="user.is_landlord">
		  <div class="mycolumn">
		    <div class="mycard bg-danger">
		      <p><i class="fa fa-user"></i></p>
		      <h3>11</h3>
		      <p>Agents</p>
		    </div>
		  </div>

		  <div class="mycolumn">
		    <div class="mycard bg-warning">
		      <p><i class="fa fa-check"></i></p>
		      <h3>55</h3>
		      <p>Houses</p>
		    </div>
		  </div>
		  
		  <div class="mycolumn">
		    <div class="mycard bg-success">
		      <p><i class="fa fa-smile-o"></i></p>
		      <h3>100</h3>
		      <p>Happy Tenants</p>
		    </div>
		  </div>
		  
		  <div class="mycolumn">
		    <div class="mycard bg-info">
		      <p><i class="fa fa-coffee"></i></p>
		      <h3>100+</h3>
		      <p>Keja Points</p>
		    </div>
		  </div>
		</div>

	</div>
</template>
<script>
	import profilePhoto from './profile_photo'
	export default {
		components:{profilePhoto},
		data (){
			return {
				user:this.$store.state.user,
				editData:{
					user_id:'',
					phone_number:'',
					postal_box:'',
					postal_code:'',
					town:''
				},
				contact:this.$store.state.user.contact,
				editContactModal:false

			}
		},
		methods:{
			editContactInfo(contact){
				let object = {
					user_id:this.$store.state.user.id,
					phone_number:contact.phone_number,
					postal_code:contact.postal_code,
					town:contact.town,
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
				this.$store.state.user.contact=res.data
				this.editData = [];
				this.editContactModal= false

			}else{
				if (res.status==422) {
					for (let i in res.data.errors) {
						this.e(res.data.errors[i][0])
					}
				}
				else{
					this.swr()
				}
			}
		}
	}
		
}
	
</script>


<style scoped>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */
.mycolumn {
  float: left;
  width: 25%;
  padding: 0 5px;
}

.myrow {margin: 0 -5px;}

/* Clear floats after the columns */
.myrow:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .mycolumn {
    width: 100%;
    display: block;
    margin-bottom: 10px;
  }
}

/* Style the counter cards */
.mycard {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;  
  color: white;
}

.fa {font-size:50px;}
</style>