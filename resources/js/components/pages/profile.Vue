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
									<p class="font-weight-bold text-success">verification status:<span class="font-weight-bold text-info">{{user.verified}}</span> </p>									
								</div>
							</div>
						</div>
					</div>
				</div>	
		</div>
	</div>
</template>
<script>
	export default {
		data (){
			return {
				user:{
					username:'',
					email:'',
					name:'',
					profile_image:''
				}
			}
		},
		async created(){
		const res= await this.callApi('get', '/user/profileData')
		if (res.status === 200) {			
			this.user = res.data
		}
		else{
			this.e('Something went wrong while loading houses')
		}
	}
	}
</script>