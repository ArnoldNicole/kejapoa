<template>
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-4">
				<div class="bg-dark float-left p-2">
					<h5 class="text-white">{{house.house_name}}</h5>
					<ButtonGroup shape="circle">
					<Button type="default"  @click="showHouseEditModal(house)"><Icon type="ios-remove-circle"/> Edit House</Button>
					<Button type="error"><Icon type="md-add"/> Delete</Button>
					<Button type="info"><Icon type="md-rose"/> Promote</Button>
				</ButtonGroup>

				<p class="text-sm-center text-white">The following contact data is shown to potential clients</p>
				<div class="text-white">
				<Icon type="ios-mail"/> arnoldwamae@gmail.com<br>
				<Icon type="md-call"/> +254708509365<br>
				<Button type="warning" shape="circle" :to="'/house/upload/'+house.id"><Icon type="md-camera"/>Upload Images</Button>
			</div>


				</div>
			</div>

				<div class="col-1">
					.
				</div>

			<div class="col-md-7 float-right card">
				<div class="card-body bg-light">
					<h4 class="float-right text-info font-weight-bold text-capitalize text-monospace">Details</h4>
					<div class="bg-light alert-info">
						<div class="border border-left-0 border-right-0 border-top-0 border-success">
							<p>House Located at {{house.geo_location}} </p>
							<p class="font-weight-bold">{{house.status}} </p>
							<p>{{house.rooms}} Room(s)</p>
							<p> {{house.condition}} </p>						
							<p class="text-info text-capitalize">{{house.rent_amount}} /= Only</p>
						</div>
						
						<div v-html="house.description">
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>

		<!-- <editModal></editModal> -->
		<Modal 
			v-model="editHouseModal"
			title="Edit House Dialogue Box"
			:mask-closable='false'
			:closable='false'
			:fullscreen='true'>

			<div slot="header">
				<Button type="error" @click="editHouseModal=false">Close</Button>
				<Button type="info" @click='editHouse'>Save Changes</Button>
				<p>You are editing {{editData.house_name}} </p>
			</div>

			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">House Name</label>
				<div class="col-md-8">
					<input v-model="editData.house_name" placeholder="Edit your House name" class="form-control" />					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">House Location</label>
				<div class="col-md-8">
					<input v-model="editData.condition" placeholder="Whats the current condition of the house" class="form-control" />					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">Rent Amount</label>
				<div class="col-md-8">
					<input v-model="editData.rent_amount" placeholder="How much are you charging monthly?" class="form-control" />					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 text-md-right col-form-label font-weight-bold">Rooms</label>
				<div class="col-md-8">
					<input v-model="editData.rooms" placeholder="How many rooms does your house have?" class="form-control" />					
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 text-md-right col-form-label font-weight-bold">Description</label>
				<div class="col-md-10">
					<vue-editor v-model="editData.description"/>
					<!-- <div v-html="editData.description">
					</div> -->					
				</div>
			</div>
			<div slot="footer">
				Use the save button on top of this Window
			</div>

		</Modal>		
				<div class="row justify-content-center">
					<div class="col-md-12 w-100">
						<h2 class="text-center font-weight-bold text-capitalize text-dark">YOUR HOUSES</h2>
						<br>
						<Carousel autoplay loop>
						        <CarouselItem v-for="(apartment, i) in houses" :key="i" v-if="houses.length">
						            <div class="demo-carousel">

						            	<div class="card">
						            		<div class="card-header">
						            			<h5 class="text-center font-weight-bold">{{apartment.house_name}}
						            				<span class="float-right text-success font-weight-bold">{{apartment.rent_amount}} Monthly</span>

						            			</h5>

						            		</div>
						            		<div class="card-body">

						            			<div class="row justify-content-center">

						            				<div class="col-md-4">
						            					<p>{{apartment.geo_location}} ; <br>
						            						{{apartment.status}} ; <br>
						            						{{apartment.rooms}} room(s)
						            					</p>
						            				</div>

						            				<div class="col-md-8">
						            					<span v-html="apartment.description">
						            					</span>
						            				</div>	

						            			</div>

						            		</div>

						            	</div>

										</div>
						            	
						        </CarouselItem>						        
						    </Carousel>
					</div>
				</div>
				<hr>
				<Row justify="center">
					<Col span="20">
						<jsz-vue-gallery v-bind:jsz-gallery="housePhotos">
											
						</jsz-vue-gallery>
					</Col>
				</Row>
			
	</div>
</template>
<script>
// import editModal from './editModal';
import JszVueGallery from 'jsz-vue-gallery'
	export default {
		components: {JszVueGallery},
		data (){
			return {
				house:{
					house_name:'',
					geo_location:'',
					status:'',
					rooms:'',
					condition:'',
					description:'',
					rent_amount:'',
				},
				housePhotos:[],
				houses:{
					house_name:'',
					geo_location:'',
					status:'',
					rooms:'',
					condition:'',
					description:'',
					rent_amount:'',
				},
				value:0,
				editHouseModal:false,
				editData: {
				house_name:'',				
				condition:'',
				rooms:'',
				description:'',
				rent_amount:''			
				
			}
			}
		},
		methods:{
			showHouseEditModal(house){
				let object = {
					id: house.id,
					house_name : house.house_name,
					geo_location: house.geo_location,
					rooms: house.rooms,
					condition: house.condition,
					description: house.description,
					rent_amount: house.rent_amount
				}

				this.editData = object
				this.editHouseModal = true				
			},
			async editHouse(){

				if (this.editData.house_name.trim()=='') {
					return this.e('House Name is Required')
				}
				if (this.editData.rooms.trim()=='') {
					return this.e('Please provide number of rooms')
				}
				if (this.editData.description.trim()=='') {
					return this.e('Check your description')
				}
				if (this.editData.condition.trim()=='') {
					return this.e('Condition is required')
				}
				if (this.editData.rent_amount.trim()=='') {
					return this.e('House Rent Amount is Required')
				}
				
				const res= await this.callApi('post', '/landlord/editHouse', this.editData)
				if (res.status==200) {
					this.house = this.editData
					this.s('House Data updated Successfully')
					this.editHouseModal=false				
				}else{
					if (res.status==422) {
						if (res.data.errors.house_name) {
							this.e(res.data.errors.house_name[0])
						}
						if (res.data.errors.condition) {
							this.e(res.data.errors.condition[0])
						}
						if (res.data.errors.rooms) {
							this.e(res.data.errors.rooms[0])
						}
						if (res.data.errors.description) {
							this.e(res.data.errors.description[0])
						}
						if (res.data.errors.rent_amount) {
							this.e(res.data.errors.rent_amount[0])
						}
					}else{
						if (res.status==401) {
							this.e('Unauthorized action')
							window.location='/login'
						}else{
							this.swr(res.data.errors) 
						}
					}
				}

				
			}
		},

		async created(){
		const res = await this.callApi('get', '/landlord/gethouse_data/' + this.$route.params.id)
		if (res.status === 200) {			
			this.house = res.data					}
		else{
			this.e('Something went wrong while loading house data')
		}
		const response = await this.callApi('get', '/landlord/myhouses')
		if (response.status === 200) {						
			this.houses = response.data
		}
		const responses = await this.callApi('get', '/json/getHouseImageData/' + this.$route.params.id)
		if (responses.status === 200) {						
			this.housePhotos = responses.data
		}
	}
	}
</script>